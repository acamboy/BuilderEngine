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

    class Admin_install extends BE_Controller
    {
        function admin_install()
        {
            parent::__construct();

            if($this->is_installed())
                redirect("/", 'location');

        }

        function ajax_validate(){
            error_reporting(0);

            if($this->input->is_ajax_request()){
                $this->output
                    ->set_content_type('application/json');

                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('', '');

                $input = $this->input->post('input');
                $value= $this->input->post('value');

                switch($input){
                    case 'txt_sitename':{
                        $this->form_validation->set_rules('value', 'Site Name', 'required');
                        break;
                    }
                    case 'txt_admin_username':{
                        $this->form_validation->set_rules('value', 'Admin Username', 'required');
                        break;
                    }
                    case 'txt_admin_email':{
                        $this->form_validation->set_rules('value', 'Admin email address', 'required|valid_email');
                        break;
                    }
                    case 'txt_admin_password':{
                        $this->form_validation->set_rules('value', 'Password', 'required');
                        break;
                    }
                    case 'txt_admin_passwordconf':{
                        $this->form_validation->set_rules('password', 'Password Confirmation', 'required');
                        $this->form_validation->set_rules('value', 'Password Confirmation', 'required|matches[password]');
                        break;
                    }
                    case 'txt_db_host':{

                        if(strlen($this->input->post('value')) == 0){
                            $this->form_validation->set_rules('value', 'MySQL host', 'required');
                        }else{
                            $link = mysql_connect( $value );
                            if(!$link){

                                if( preg_match("/^Can't connect to MySQL server on(.*)/i", trim(mysql_error())) ||
                                    preg_match("/^Unknown MySQL server host (.*)/i", trim(mysql_error()))){
                                    echo json_encode(array('result' => FALSE, 'input' => $input, 'error_message' => mysql_error()));
                                }
                                else{
                                    echo json_encode(array('result' => TRUE, 'input' => $input, 'development_info' => mysql_error()));
                                }
                            }else{
                                echo json_encode(array('result' => TRUE, 'input' => $input));
                            }
                            exit();
                        }
                        break;
                    }
                    case 'txt_db_name':{


                        if(strlen($this->input->post('value')) == 0){
                            $this->form_validation->set_rules('value', 'MySQL database', 'required');
                        }else{
                            $host = $this->input->post('host');
                            $user = $this->input->post('username');
                            $pass = $this->input->post('passowrd');
                            $db = $this->input->post('value');

                            $link = mysql_connect( $host, $user, $pass );

                            if(!$link){
                                echo json_encode(array('result' => FALSE, 'input' => $input, 'error_message' => 'Check database credentials first!'));
                            }else{

                                $db_selected = mysql_select_db($db, $link);
                                if (!$db_selected) {
                                    echo json_encode(array('result' => FALSE, 'input' => $input, 'error_message' => "Database doesn't exist"));
                                }else{
                                    echo json_encode(array('result' => TRUE, 'input' => $input));
                                }
                            }
                            exit();
                        }
                        break;

                    }
                    case 'db_credentials':{
                        error_reporting(0);
                        if(strlen($this->input->post('value')) == 0){
                            $this->form_validation->set_rules('value', 'MySQL host', 'required');
                        }else{
                            $host = $this->input->post('host');
                            $user = $this->input->post('username');
                            $pass = $this->input->post('passowrd');

                            $link = mysql_connect( $host, $user, $pass );
                            if(!$link){

                                if( preg_match("/^Can't connect to MySQL server on(.*)/i", trim(mysql_error())) ||
                                    preg_match("/^Unknown MySQL server host (.*)/i", trim(mysql_error()))){
                                    echo json_encode(array('result' => FALSE, 'input' => $input, 'error_message' => 'Check your Database Host first!'));
                                }
                                elseif(preg_match("/^Access denied for user(.*)/i", trim(mysql_error()))){
                                    echo json_encode(array('result' => FALSE, 'input' => $input, 'error_message' => 'Unknown user, wrong password or denied access'));
                                }else{
                                    echo json_encode(array('result' => FALSE, 'input' => $input, 'error_message' => 'Unknown Database error: ' . mysql_error()));
                                }
                            }else{
                                echo json_encode(array('result' => TRUE, 'input' => $input));
                            }

                            exit();

                        }

                        break;

                    }
                    default:{break;}
                }


                if ($this->form_validation->run() == FALSE)
                {
                    $this->output
                        ->set_output(json_encode(array('result' => FALSE, 'input' => $input, 'error_message' => form_error('value'))));
                }
                else
                {
                    $this->output
                        ->set_output(json_encode(array('result' => TRUE, 'input' => $input)));
                }
            }

        }


        function index()
        {
            $this->step_one();
        }

        function create_admin()
        {
            $this->load->database();
            $this->load->model("users");

            $admin['username']  = $this->input->post('admin_username');
            $admin['password']  = $this->input->post('admin_password');
            $admin['email']     = $this->input->post('admin_email');
            $admin['groups']    = "Members,Administrators,Frontend Editor,Frontend Manager";
            $admin['verified']   = 'yes';
            $this->BuilderEngine->set_option('adminemail', $this->input->post('admin_email'));

            $this->users->register_user($admin);
            echo "success";
        }
        function install_db()
        {
            $this->show->disable_full_wrapper();
            $host = $this->input->post('host');
            $user = $this->input->post('user');
            $password = $this->input->post('password');
            $db = $this->input->post('db');

            error_reporting(0);

            $link = mysql_connect( $host, $user, $password );

            if (!$link) {
                die('Not connected : ' . mysql_error() . ' ,' . $host);
            }
            $db_selected = mysql_select_db($db, $link);
            if (!$db_selected) {
                die ('Can\'t use '. $db.' : ' . mysql_error());
            }

            $queries = file_get_contents(APPPATH."install/database.sql");

            if($queries === null)
                die("PHP function <a href='http://php.net/file_get_contents'>file_get_contents()</a> is disabled by your server administrator");
                
            if($queries === false)
                die("Could not read database import file.");
                
            
            
                
            foreach(explode(";", $queries) as $query)
            {
                if($query == '')
                    continue;
                    
                mysql_query($query) or die("Database Error: ".mysql_error()."<br>Query: '$query'");
            }

            $config = file_get_contents(APPPATH."config/database_template.php");
            $config = str_replace("##DB_HOST##", $host, $config);
            $config = str_replace("##DB_USER##", $user, $config);
            $config = str_replace("##DB_PASS##", $password, $config);
            $config = str_replace("##DB_NAME##", $db, $config);

            file_put_contents(APPPATH."config/database.php", $config) or die("Could not create database configuration file.");

            echo "success";
        }
        function finish()
        {
            $config = file_get_contents(APPPATH."config/config.php");
            $config = str_replace('$config[\'site_installed\'] = false;', '$config[\'site_installed\'] = true;', $config);

            file_put_contents(APPPATH."config/config.php", $config);
            echo "success";
        }
        function configure(){
            $this->output
                ->set_content_type('application/json');

            if($this->input->is_ajax_request()) {

                $sitename   = $this->input->post('sitename');
                $host       = $this->input->post('host');
                $user       = $this->input->post('user');
                $password   = $this->input->post('password');
                $db         = $this->input->post('db');

                $this->load->database();
                $this->BuilderEngine->load_settings();
                $this->BuilderEngine->set_option("website_name", $sitename);
                $this->BuilderEngine->set_option("website_title", $sitename);

                $this->output
                    ->set_output(json_encode(array('result' => TRUE)));

            }else{
                $this->output
                    ->set_output(json_encode(array('result' => FALSE)));
            }


        }
        function step_one()
        {

            $requirements = array();
            if(array_key_exists('HTTP_MOD_REWRITE', $_SERVER) && $_SERVER['HTTP_MOD_REWRITE'] == "On")
                $requirements['mod_rewrite'] = true;
            else
                $requirements['mod_rewrite'] = false;

            $requirements['short_tags'] = ini_get('short_open_tag') == "1";

            $requirements['writable'] = check_writable_recurse(".") ;
            $requirements['php_version'] = check_php_version("5.0") ;
            $requirements['mysql_available'] = function_exists("mysql_connect") && function_exists("mysql_select_db") && function_exists("mysql_query") ;
            


            $data['requirements'] = $requirements;
            $this->load->helper('bs_progressbar');
            $this->load->helper('form');
            $this->show->backend('maintenance_install', $data);




        }

    }
?>