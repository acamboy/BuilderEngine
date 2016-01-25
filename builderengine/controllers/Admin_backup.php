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

    class Admin_backup extends BE_Controller{

        public function __construct(){
            parent::__construct();
            $this->user->require_group("Administrators");
        }

        public function backup()
        {
            $data['current_page'] = 'settings';
            $this->load->helper('bs_progressbar');
            $this->show->backend('backup', $data);
        }

        public function backup_files()
        {
            $time = time();

            if(!is_dir('compressed'))
                mkdir('compressed');

            mkdir('compressed/'.$time);

            try{
                $res = $this->Zip('./', 'compressed/'.$time.'/file.zip');
            }

            catch (Exception $e) {
                $this->delete_directory('compressed/'.$time);

                echo json_encode(array('result'=>false));die;
            }

            if($res)
                echo json_encode(array('result'=>true,'time'=>$time));
            else
                echo json_encode(array('result'=>false));
        }

        function delete_directory($dirname) {
            if (is_dir($dirname))
                $dir_handle = opendir($dirname);

            if (!$dir_handle)
                return false;

            while($file = readdir($dir_handle)) {
                if ($file != "." && $file != "..") {
                    if (!is_dir($dirname."/".$file))
                        unlink($dirname."/".$file);
                    else
                        delete_directory($dirname.'/'.$file);
                }
            }

            closedir($dir_handle);
            rmdir($dirname);
            return true;
        }

        public function backup_db($tables = '*',$file_name = 'sql')
        {
            if(isset($_GET['time']) && $_GET['time']){

                $time = $_GET['time'];

                try{

                    $this->load->database();

                    $host = $this->db->hostname;
                    $user = $this->db->username;
                    $pass = $this->db->password;
                    $name = $this->db->database;
                    $return = '';

                    $link = new PDO('mysql:host='.$host.';dbname='.$name, $user, $pass);
                    
                    //get all of the tables
                    if($tables == '*')
                    {
                        $tables = array();
                        $result = $link->query('SHOW TABLES');
                        while($row = $result->fetch())
                        {
                            $tables[] = $row[0];
                        }
                    }
                    else
                    {
                        $tables = is_array($tables) ? $tables : explode(',',$tables);
                    }
                    
                    //cycle through
                    foreach($tables as $table)
                    {
                        $result = $link->query('SELECT * FROM '.$table);
                        $num_fields = $result->columnCount();

                        $res = $link->query('SHOW CREATE TABLE '.$table);
                        $row2 = $res->fetch();

                        $return.= "\n\n".$row2[1].";;\n\n";
                        
                        for ($i = 0; $i < $num_fields; $i++) 
                        {
                            while($row = $result->fetch())
                            {
                                $return.= 'INSERT INTO '.$table.' VALUES(';
                                for($j=0; $j<$num_fields; $j++) 
                                {
                                    $row[$j] = addslashes($row[$j]);
                                    $row[$j] = preg_replace("/\n/","\\n",$row[$j]);
                                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                                    if ($j<($num_fields-1)) { $return.= ','; }
                                }
                                $return.= ");;\n";
                            }
                        }
                        $return.="\n\n\n";
                    }
                    
                    //save file
                    $handle = fopen('compressed/' . $time . '/' . $file_name . '.sql','w+');
                    fwrite($handle,$return);
                    fclose($handle);

                    echo json_encode(array('result'=>true,'time'=>$time));
                }
                catch (Exception $e) {
                    $this->delete_directory('compressed/'.$time);

                    echo json_encode(array('result'=>false));die;
                }
            }else{
                echo json_encode(array('result'=>false));
            }
        }

        public function Zip($source, $destination)
        {
            set_time_limit(0);

            if (extension_loaded('zip') === true)
            {
                if (file_exists($source) === true)
                {
                    $zip = new ZipArchive();

                    if ($zip->open($destination, ZIPARCHIVE::CREATE) === true)
                    {
                        $source = realpath($source);

                        if (is_dir($source) === true)
                        {
                            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
                            foreach ($files as $file)
                            {
                                $file = realpath($file);

                                $file_name = str_replace($source , '', $file);
                                $file_name = trim($file_name,'/');
                                $file_name = trim($file_name,'\\');

                                if ((strpos($file_name,'compressed') === false) && ($file_name != $source) && (strpos($file_name,'xampp') === false) && (strpos($file_name,'.git') === false))
                                {
                                    if (is_dir($file) === true)
                                    {
                                        $zip->addEmptyDir($file_name);
                                        // $zip->addEmptyDir(str_replace($source . '\\', '', $file));
                                    }

                                    else if (is_file($file) === true)
                                    {
                                        $zip->addFromString($file_name, file_get_contents($file));
                                        // $zip->addFromString(str_replace($source . '\\', '', $file), file_get_contents($file));
                                    }
                                }
                            }
                        }

                        else if (is_file($source) === true)
                        {
                            $zip->addFromString(basename($source), file_get_contents($source));
                        }
                    }

                    return $zip->close();
                }
            }

            return false;
        }

        /* functionaly for restore */

        public function restore()
        {
            if(is_dir('compressed')){
                $scandir = scandir('compressed');
                $data['update'] = $scandir;
            }else{
                $data['update'] = array();
            }

            $data['current_page'] = 'settings';
            $this->load->helper('bs_progressbar');
            $this->show->backend('restore', $data);
        }

        public function restore_sql($table_name = '*', $file_name = 'sql')
        {
            if(isset($_GET['time']) && $_GET['time']){

                $time = $_GET['time'];

                $this->load->database();

                $host = $this->db->hostname;
                $user = $this->db->username;
                $pass = $this->db->password;
                $name = $this->db->database;

                $mysqli = new mysqli($host, $user, $pass, $name);
                $mysqli->query('SET foreign_key_checks = 0');
                if($table_name == '*'){
                    if ($result = $mysqli->query("SHOW TABLES"))
                    {
                        while($row = $result->fetch_array(MYSQLI_NUM))
                        {
                            $mysqli->query('DROP TABLE IF EXISTS `'.$row[0].'`');
                        }
                    }
                }else{
                     $mysqli->query('DROP TABLE IF EXISTS `'.$table_name.'`');
                }

                $mysqli->query('SET foreign_key_checks = 1');
                $mysqli->close();

                $sql = file_get_contents('compressed/' . $time . '/' . $file_name . '.sql');

                $query = explode (";;", $sql);

                unset($query[count($query)]);
                foreach($query as $statement)
                    if($statement && !ctype_space($statement))
                        $this->db->query($statement);

                echo json_encode(array('result'=>true,'time'=>$time));
            }else{
                echo json_encode(array('result'=>false));
            }
        }

        function restore_files()
        {
            set_time_limit(0);

            if(isset($_GET['time']) && $_GET['time']){

                $time = $_GET['time'];
                $zip = new ZipArchive();

                $file_path = "compressed/".$time.'/file.zip';
                if ($zip->open($file_path) === TRUE) {
                  $files = array();
                    for( $i = 0; $i < $zip->numFiles; $i++){
                        $entry = $zip->statIndex($i);
                        if( $entry['size'] > 0 ){
                            $f_extract = $zip->getNameIndex($i);
                            $files[] = $f_extract;
                        }
                    }

                    if ($zip->extractTo('./', $files) === TRUE) {
                    } else {
                        return FALSE;
                    }

                    $zip->close();
                    echo json_encode(array(
                        'result'    =>  true,
                        'time'      =>  $time
                    ));
                }else{
                    echo json_encode(array('result'=>false));    
                }
            }else{
                echo json_encode(array('result'=>false));
            }
        }
    }
