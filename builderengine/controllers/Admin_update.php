<?php
/***********************************************************
 * BuilderEngine v3.1.0
 * ---------------------------------
 * BuilderEngine CMS Platform - Radian Enterprise Systems Limited
 * Copyright Radian Enterprise Systems Limited 2012-2015. All Rights Reserved.
 *
 * http://www.builderengine.com
 * Email: info@builderengine.com
 * Time: 2015-08-31 | File version: 3.1.0
 *
 ***********************************************************/

error_reporting(0);

class Admin_update extends BE_Controller
{

    function admin_install()
    {
        parent::__construct();

        if($this->is_installed())
            redirect("/", 'location');

    }

    /**
     *
     */
    function check_updates()
    {

        echo $this->update_check();
    }

    function prepare_update(){
        header('Content-Type: application/json');
        if (file_exists(APPPATH.'update/backup.zip')) {
            unlink(APPPATH.'update/backup.zip');
        }
        if (file_exists(APPPATH.'update/update.zip')) {
            unlink(APPPATH.'update/update.zip');
        }
        echo json_encode(array('result'=>TRUE));

    }



    function set_backup(){

        try {

            $zip = new ZipArchive();
            $file_path = APPPATH.'update/backup.zip';
            if (file_exists($file_path)) {
                $zip->open($file_path);
            }else{
                $zip->open(APPPATH.'update/backup.zip', ZipArchive::CREATE);
            }

            $files = json_decode($this->input->post('file_set'));

            foreach($files as $file){
                $zip->addFile($file, $file);
            }

            $zip->close();

            echo json_encode(array('result' => TRUE));

        } catch (Exception $e) {
            echo json_encode(array('result'=>$e));
        }

    }


    function download()
    {

        header('Content-Type: application/json');

        @mkdir(APPPATH."update");

        $update_file = $this->update_download($this->input->post('ver'));
        $asked = json_decode($this->input->post('asked'));

        $file_path = APPPATH."update/update.zip";
        file_put_contents($file_path, $update_file);
        if(file_get_contents($file_path) == $update_file){
            $zip = new ZipArchive();
            $file_path = APPPATH."update/update.zip";
            if ($zip->open($file_path) === TRUE) {

                $files_beign_modified = array();

                for ($i = 0; $i < $zip->numFiles; $i++){
                    $_file = $zip->statName($zip->getNameIndex($i));
                    if( (!preg_match("/\/$/", $_file['name'])) && (!in_array($_file['name'], $asked)) )
                    {//is not a directory...
                        array_push($asked,$_file['name']);
                        if(file_exists($_file['name'])){
                            if( (int)sprintf("%u",$_file['crc']) !== (int)sprintf("%u", crc32(file_get_contents($_file['name']))) )
                            {
                                $found = FALSE;
                                if (file_exists(APPPATH.'update/backup.zip')) {
                                    $zip_target = new ZipArchive();
                                    if ($zip_target->open(APPPATH.'update/backup.zip') === TRUE) {
                                        for ($j = 0; $j < $zip_target->numFiles; $j++){
                                            $_bked_file = $zip_target->statName($zip_target->getNameIndex($j));
                                            if($_bked_file['name'] ===  $_file['name']){
                                                $found = TRUE;
                                                break;
                                            }
                                        }
                                        $zip_target->close();
                                    }
                                }
                                if(!$found){
                                    array_push($files_beign_modified, $_file['name']);
                                }
                            }
                        }
                    }
                }
                $zip->close();
                echo json_encode(array(
                    'result' 	=>	true,
                    'files'		=>	$files_beign_modified,
                    'asked'   =>  $asked
                ));
            }
        }
        else
            echo json_encode(array('result' => false));

    }
    function update_files(){
        header('Content-Type: application/json');
        $zip = new ZipArchive;
        $file_path = APPPATH."update/update.zip";
        if ($zip->open($file_path) === TRUE) {
            $zip->extractTo('.');
            $zip->close();



            unlink(APPPATH."update/update.zip");

            if(file_exists(APPPATH."update/update.php"))
                include(APPPATH."update/update.php");

            unlink(APPPATH."update/update.php");
            echo json_encode(array('result'=>TRUE));
        } else {
            echo json_encode(array('result'=>FALSE));
        }
    }

    function update_db()
    {
        header('Content-Type: application/json');
        if(!file_exists(APPPATH."update/sql/update.sql")){
            echo json_encode(array('result'=>TRUE));
            return;
        }

        $sql = file_get_contents(APPPATH."update/sql/update.sql");

        $query = explode (";", $sql);

        unset($query[count($query)]);
        foreach($query as $statement){
            if($statement)
                $this->db->query($statement);
        }
        unlink(APPPATH."update/sql/update.sql");
        echo json_encode(array('result'=>TRUE));
    }
    function finish()
    {
        header('Content-Type: application/json');
        $this->BuilderEngine->set_option('version',$this->input->post('ver'));

        Modules::run("builder_market/admin/update_products");
        /*
        $this->load->model("users");
        $this->users->delete_alerts_with_tag("be-update");
        */
        echo json_encode(array('result'=>TRUE));
    }
    function index()
    {

        $updates = json_decode($this->update_check());

        if($updates->result && $updates->available_updates > 0){

            $requirements = array();
            $requirements['writable'] = check_writable_recurse(".") ;
            $requirements['php_version'] = check_php_version("5.0") ;
            $requirements['mysql_available'] = function_exists("mysql_connect") && function_exists("mysql_select_db") && function_exists("mysql_query") ;
            $requirements['mod_rewrite'] = getenv(HTTP_MOD_REWRITE) == "On" ;

            $data['requirements'] = $requirements;
            //$this->show->backend('maintenance/update', $data);
            $this->load->helper('bs_progressbar');
            $this->show->backend('maintenance_update', $data);

        }else{
            redirect('/admin', 'location');die;
        }


    }
}
?>
