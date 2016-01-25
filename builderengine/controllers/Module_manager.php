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

    class Module_manager extends BE_Controller
    {
        function index(){
            $this->process('page');
        }
        
        function parse($argv, &$handler, &$parameters)
        {

            $handler[1] = "";
            $parameters[1] = array();

            $handler[1] = $argv[0]."/_remap";
            
            
            for($i = 1; $i < count($argv); $i++)
                array_push($parameters[1], $argv[$i]);
           
            if(count($parameters[1]) == 0)
                array_push($parameters[1], "index");   


            if(isset($argv[1])){
                $handler[0] = "";
                $parameters[0] = array();

                $handler[0] = $argv[0]."/".$argv[1]."/_remap";
                
                
                for($i = 2; $i < count($argv); $i++)
                    array_push($parameters[0], $argv[$i]);
               
                if(count($parameters[0]) == 0){
                    array_push($parameters[0], $parameters[1][0]);
                }
            }
        }

        function parse_ajax($argv, &$handler, &$parameters)
        {

            $handler = "";
            $parameters = array();

            $handler = $argv[0]."/ajax/".$argv[1];
            
            
            for($i = 1; $i < count($argv); $i++)
                array_push($parameters, $argv[$i]);
           
            if(count($parameters) == 0)
                array_push($parameters, "index");    
        
        }
        function process_seo()
        {

            $original_argv = func_get_args();

            $data = explode("-", $original_argv[0],2);

            global $BuilderEngine;
            $this->show->set_frontend();
            $this->load->model('users');

            $argv = $data;

            $handler = "";
            $parameters = "";
            $this->parse($argv, $handler, $parameters);


            $parameters_string = implode("/", $parameters[1]);
            $page_path = $argv[0]."/".$parameters_string;

            $BuilderEngine->set_page_path($page_path);
            

            $module_folder = explode("/", $handler[1]);

            $module = new Module();
            $module = $module->where('folder', $module_folder[0])->get();


            if(empty($module->id)){
                if(is_dir(APPPATH."../modules/".$module_folder[0])){
                    $module->folder = $module_folder[0];
                    $module->installer_id = -1;
                    $module->installed = 'no';
                    $module->save();
                }else{
                    return show_404();
                }
            }
            if($module->installed == 'no' || !$this->user->can_access_module($module, 'frontend')){
                //show_404();
                echo"Forbidden";
                return;
            }

            /*$result = $this->cache->fetch("cached-page-".$page_path);
            if($result)
            {
                echo $result;
                return;
            }*/

            if(isset($handler[0]))
                $data['contents'] = Modules::run_with_params($handler[0], $parameters[0]);


            //die("Data: ".$data['contents']);  
            
            if(!isset($handler[0]) || $data['contents'] == "__NO_MODULE__" ){
                $data['contents'] = Modules::run_with_params($handler[1], $parameters[1]);
            }else{
            }
                

                
            if($data['contents'] == "__404__" || $data['contents'] == "__NO_MODULE__")
            {
                die("blabla");
                $data = explode("-", $original_argv[0]);
                call_user_func_array(array($this, "process"), $data);
                return;
            }
                

            if(isset($_POST['be_editor_frame']))
            {
                $this->user->set_session_data('is_editor_active', true);
            }
            $this->show->frontend('full',$data);
            if(!$this->user->get_session_data('is_editor_active') && ($this->user->is_member_of("Administrators") || $this->user->is_member_of("Frontend Editor") || $this->user->is_member_of("Frontend Manager") ))
            {

                $CI = & get_instance();
                $CI->output->append_output("
                    
                        ");
            }
            global $BuilderEngine;
            if(!$BuilderEngine->is_editor_active())
                $this->BuilderEngine->register_visit($this->get_page_path());

        }
        function module_exclusive_rights($module)
        {
            if($module->folder == "module_system")
                return true;

            if($module->folder == "layout_system")
                return true;

            if($module->folder == "builder_market")
                return true;

            return false;
        }
        function process($par1)
        {
            global $BuilderEngine;

            $argv = func_get_args();
            switch ($argv[0]) {
                case 'page':
                    $this->show->set_frontend();
                break;
                case 'social':
                    $this->show->set_social_frontend();
                    $this->show->set_social_backend();
                break;
                default:
                    $this->show->set_frontend();
                    break;
            }
            $this->load->model('users');


            $handler = "";
            $parameters = "";
            $this->parse($argv, $handler, $parameters);


            $parameters_string = implode("/", $parameters[1]);
            $page_path = $argv[0]."/".$parameters_string;

            $BuilderEngine->set_page_path($page_path);


            $module_folder = explode("/", $handler[1]);

            $module = new Module();
            $module = $module->where('folder', $module_folder[0])->get();


            if(empty($module->id)){
                if(is_dir(APPPATH."../modules/".$module_folder[0])){
                    $module->folder = $module_folder[0];
                    $module->installer_id = -1;
                    $module->installed = 'no';
                    $module->save();
                }else{
                	if(EventManager::fire("builderengine_default_route"))
                		return;
                    return show_404();
                }
            }
            if(($module->installed == 'no' || !$this->user->can_access_module($module, 'frontend')) && !$this->module_exclusive_rights($module)){
                //show_404();
                echo"Forbidden";
                return;
            }

            /*$result = $this->cache->fetch("cached-page-".$page_path);
            if($result)
            {
                echo $result;
                return;
            }*/

            if(!$BuilderEngine->is_editor_active())
            {
                if(isset($handler[0]))
                    $data['contents'] = Modules::run_with_params($handler[0], $parameters[0]);

                if(!isset($handler[0]) || $data['contents'] == "__NO_MODULE__" || $data['contents'] == "__404__"){
                    $data['contents'] = Modules::run_with_params($handler[1], $parameters[1]);
                }else{
                }
                if($data['contents'] == "__404__" || $data['contents'] == "__NO_MODULE__")
                {
                	if(EventManager::fire("builderengine_default_route"))
                		return;
                    return show_404();
                }
                    

                if(isset($_POST['be_editor_frame']))
                {
                    $this->user->set_session_data('is_editor_active', true);
                }
                $this->show->frontend('full',$data);
            }else
                $this->show->frontend('full');

                
            
            
            if(!$this->user->get_session_data('is_editor_active') && ($this->user->is_member_of("Administrators") || $this->user->is_member_of("Frontend Editor") || $this->user->is_member_of("Frontend Manager") ))
            {

              
            }
            global $BuilderEngine;
            if(!$BuilderEngine->is_editor_active())
                $this->BuilderEngine->register_visit($this->get_page_path());

        	
        }

        function process_api($par1)
        {
            global $BuilderEngine;
            $this->show->set_frontend();
            $this->load->model('users');

            $argv[0] = "api";
            $argv = array_merge($argv, func_get_args());

            $handler = "";
            $parameters = "";
            $this->parse($argv, $handler, $parameters);


            $parameters_string = implode("/", $parameters[1]);
            $page_path = $argv[0]."/".$parameters_string;



            $module_folder = explode("/", $handler[1]);


            /*$result = $this->cache->fetch("cached-page-".$page_path);
            if($result)
            {
                echo $result;
                return;
            }*/

            if(!$BuilderEngine->is_editor_active())
            {
                if(isset($handler[0]))
                    $data['contents'] = Modules::run_with_params($handler[0], $parameters[0]);

                if(!isset($handler[0]) || $data['contents'] == "__NO_MODULE__" || $data['contents'] == "__404__"){
                    $data['contents'] = Modules::run_with_params($handler[1], $parameters[1]);
                }else{
                }
                if($data['contents'] == "__404__" || $data['contents'] == "__NO_MODULE__")
                {
                    if(EventManager::fire("builderengine_default_route"))
                        return;
                    return show_404();
                }
                    

                if(isset($_POST['be_editor_frame']))
                {
                    $this->user->set_session_data('is_editor_active', true);
                }
                $this->show->frontend('full',$data);
            }else
                $this->show->frontend('full');

                
            
            
        }

        function process_ajax($par1)
        {
            global $BuilderEngine;
            $this->show->set_frontend();
            $this->load->model('users');

            $argv = func_get_args();

            $handler = "";
            $parameters = "";

            $this->parse($argv, $handler, $parameters);

            $parameters_string = implode("/", $parameters[1]);
            $page_path = $argv[0]."/".$parameters_string;

            //$BuilderEngine->set_page_path($page_path);
            $output =  Modules::run_with_params($handler[0], $parameters[0]);

            if($output == "__404__" || $output == "__NO_MODULE__")
                return show_404();

            echo $output;
 
        }

        function process_editor()
        {
            //echo "Intercepted";
            global $BuilderEngine;

            $BuilderEngine->set_editor_active();
            $argv = func_get_args();
            PC::vardumps($argv, '$argv');

            if(strstr($argv[0], ".html")){
                $argv[0] = str_replace(".html", "", $argv[0]);
                $data = explode("-", $argv[0], 2);
                call_user_func_array(array($this, 'process'), $data); 
            }
                   
            else{
                call_user_func_array(array($this, 'process'), $argv);
            }
                

        }
        function process_admin($par1)
        {
            $this->load->model('users');
            
            if(!$this->user->is_member_of("Administrators"))
                redirect(base_url("/admin/main/login"), 'location');

            $argv = func_get_args();
            $handler = "";
            for($i = 0; $i < 3; $i++)
            {
                $handler .= $argv[$i]."/";
                unset($argv[$i]);
            }
            
            $handler = trim($handler ,"/");
            $argv = array_values($argv);

            $module_folder = explode("/", $handler);

            $module = new Module();
            $module = $module->where('folder', $module_folder[0])->get();


            if(empty($module->id)){
                if(is_dir(APPPATH."../modules/".$module_folder[0])){
                    $module->folder = $module_folder[0];
                    $module->installer_id = -1;
                    $module->installed = 'no';
                    $module->save();
                }else{
                    return show_404();
                }
            }
            if(($module->installed == 'no' || !$this->user->can_access_module($module, 'frontend')) && !$this->module_exclusive_rights($module)){
                //show_404();
                echo"Forbidden";
                return;
            }

            if(!is_array($argv))
                $argv = array($argv);
            
            $data['contents'] = Modules::run_with_params($handler, $argv);
            $breadcrumb = explode("/", $handler);
            $breadcrumb[0][0] = strtoupper($breadcrumb[0][0]);
            if(!isset($this->show->breadcrumb[0])){
                $this->show->breadcrumb[0]['name'] = $breadcrumb[0];
                $this->show->breadcrumb[0]['url'] = "";
            }
            $name = explode("_", $breadcrumb[2]);
            foreach($name as &$segment)
            {
                $segment[0] = strtoupper($segment[0]);
            }
            $breadcrumb[2] = implode(" ", $name);
            $this->show->breadcrumb[1]['name'] = $breadcrumb[2];
            $this->show->breadcrumb[1]['url'] = "#";

            $this->show->backend('blank',$data);
        }
    }
