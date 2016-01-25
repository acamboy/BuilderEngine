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

include_once("core_functions.php");
includeRecurse(APPPATH."/core/classes");


require_once(APPPATH."third_party/MX/Controller.php");
global $active_controller;
global $cache;
    class BE_Controller extends MX_Controller{
    	/**
    	 * @var CI_Loader
    	 */
    	var $load;

        public $show;
        public $user;
        public static $s_user = null;
        public $links_array;
        protected $page_path;
        protected $versions = null;
        private static $s_events = null;

        private $_server_URL = 'http://update-server.builderengine.com';

        
        public function update_download($ver = FALSE){
            $default = FALSE;

            if($ver){
                $payload = http_build_query(array(
                    'client'    =>  'installedCMS',
                    'file'   =>  $this->BuilderEngine->get_option('version').'-to-'.$ver,
                    'time'      =>  time()));
                return file_get_contents($this->_server_URL.'/download.php?'.$payload);
            }else{
                return $default;
            }
        }

        public function update_check($ver = FALSE){

            $payload = http_build_query(array(
                'client'    =>  'installedCMS',
                'version'   =>  ($ver) ? $ver : $this->BuilderEngine->get_option('version'),
                'time'      =>  time()));
            return file_get_contents($this->_server_URL.'/check.php?'.$payload);

        }

        function BE_Controller()
        {
            $this->page_path = false;
            global $active_controller;
            global $active_show;
            $active_controller = $this;
            parent::__construct();

            $this->load->helper("url");
            if(!$this->is_installed() && $this->uri->segment(2) != "install" && $this->uri->segment(1) != "api"){
                redirect('/admin/install/index', 'location');
            }

            if($this->is_installed()){
                $this->load->database();
                @$this->load->library('datamapper');
            }

            


            if(!$active_show)
                $this->show = new Show($this);
            else
                $this->show = &$active_show;
            $this->load->model('BuilderEngine');
            $this->load->model('users');

            

            if($this->is_installed()){
                $this->load->model('user');
                global $cache;
                $this->load->model("cache");
                $cache = $this->cache;


                $this->BuilderEngine->load_settings();

                if(!EventManager::is_initialized() && !EventManager::is_initializing())
                {
                    EventManager::set_initializing(true);
                    $this->load->model('module');
                    $modules = $this->module;
                    // $modules = new Module();

                    foreach($modules->get() as $module)
                    {
                        if($module->folder == "module_system")
                            continue;
                        Modules::run($module->folder."/register_events");
                    }

                    EventManager::set_initialized(true);
                }
                
                if(self::$s_user == null)
                {
                    self::$s_user = new User();
                    $session = $this->session;
                    
                    self::$s_user->_init($session);
                }
                
                $user_model = $this->users;

                global $user;
                $user = self::$s_user;
                $this->user = &self::$s_user;
                $CI =& get_instance();
                $this->load->model('links');

                $this->links_array = $this->links->get();

                foreach($this->links_array as $link)
                {
                    $link->target = str_replace("%site_root%", home_url('/'), $link->target);
                }
                
            }
            $this->BuilderEngine->set_option("active_backend_theme","dashboard", false);
            $this->load->library('module_parser');
            $this->load->library('parser');

            //$this->BuilderEngine->activate_theme("default");

            //echo $this->get_page_path();

            $this->load->module("layout_system");
            $this->layout_system->load->model("blocks");

            $this->layout_system->load->model('versions');
            $this->versions = &$this->layout_system->versions;

            if($this->is_installed())
            {
                $this->load->model('Module');
                $this->load->model('Group');
                $this->load->model('Group_module_permission');
            }
            
        }
        public function get_builderengine()
        {
            return $this->BuilderEngine;
        }
        public function get_page_versions($page_path = null)
        {
            return $this->versions->get_page_versions(($page_path != null) ? $page_path : $this->get_page_path());
        }

        public function get_page_path()
        {
            global $BuilderEngine;
            return $BuilderEngine->get_page_path();

            //Old code below
            if(!$this->page_path)
                die("No Path");
            $path = "";
            $i = 1;
            if($this->uri->rsegments[1] == "module_manager")
            {
                $path = "module/";
                $i += 2;
            }

            for($i; $i <= count($this->uri->rsegments); $i++)
            {
                $path .= $this->uri->rsegments[$i]."/";
            }
            $path = trim($path, "/");
            return $path;
        }
        public function is_installed()
        {
            return file_exists("builderengine/config/database.php") && $this->config->item("site_installed");
        }
        public function get_user()
        {
            return $this->user;
        }
        public function get_links($tag = "")
        {
            if($tag != "")
                return $this->links->get_by_tag($tag);
            
            return $this->links_array;
        }
        public function show()
        {
            //commented function
            // if(file_exists("themes/".$this->BuilderEngine->get_active_theme()."/".$view.".php"))
            //     $this->load->view("../../themes/".$this->BuilderEngine->get_active_theme()."/".$view);
            // else
            //     die ("File "."themes/".$this->BuilderEngine->get_active_theme()."/".$view.".php");
        }
        
    }

    class Module_Controller extends BE_Controller{
        private $initialized = false;
        private function _initialize()
        {
            unset($this->versions);
            $this->load->model("versions"); //hackfix
            unset($this->users);
            $this->load->model("users"); //hackfix
            unset($this->presentation);
            $this->load->model("be_presentation", "presentation"); //hackfix
            $this->initialize();
            $this->initialized = true;
        }
        public function initialize()
        {

        }
        public function _remap($method)
        {
            //echo "Method: $method <br>\n";
            //echo "Params: ";
            PC::_remap(func_get_args());
            $params = array_slice(func_get_args(), 1);
            if(!is_array($params))
            {
                $val = $params;
                $params = array($val);
            }
            

            if(method_exists($this, $method)){
                if(!$this->initialized)
                    $this->_initialize();
                return call_user_func_array(array($this, $method), $params);    
            }
                

            $string[0] = $method;
            for($i = 0; $i < count($params); $i++)
            {
                array_push($string, $params[$i]);
            }
            if ((strrpos($method, '.html') === strlen($method) - 5) && method_exists($this, "seo"))
            {
                if(!$this->initialized)
                    $this->_initialize();
                return call_user_func_array(array($this, "seo"), $string);
            }

            if(method_exists($this, "query"))
            {
                if(!$this->initialized)
                    $this->_initialize();
                return call_user_func_array(array($this, "query"), $string);
            }

            if(method_exists($this, "index"))
            {
                if(!$this->initialized)
                    $this->_initialize();
                return call_user_func_array(array($this, "index"), $string);
            }
                

           return "__404__";
        }
    }
