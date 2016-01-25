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

    global $active_show;

    class Show{

        public $controller;
        public $frontend = false;
        public $user_backend = false;
        public $social_backend = false;
        public $isolated;
        public $editor_tools_enabled = true;
        public $breadcrumb;

        function Show($controller)
        {
            global $active_show;

            //Take care of initializing the active_show with the FIRST show object, otherwise multiple show objects are created
            //This causes the frontend flag and shows to mess up if more than one controller inherits BE_Controller
            if(!is_null($active_show)) return;

            $this->controller = $controller;
            $this->isolated = false;

            $active_show = $this;
            $this->breadcrumb = array();
        }
        function set_default_breadcrumb($index, $name, $url)
        {
            $this->breadcrumb[$index]['name'] = $name;
            $this->breadcrumb[$index]['url'] = $url;

        }
        function set_frontend()
        {
            global $active_show;
            $active_show->frontend = true;
        }
        function set_social_frontend()
        {
            global $active_show;
            $active_show->social_frontend = true;
        }
        function set_user_backend()
        {
            global $active_show;
            $active_show->user_backend = true;
        }
        function set_social_backend()
        {
            global $active_show;
            $active_show->social_backend = true;
        }
        function theme_file_exists($file)
        {
            return file_exists(APPPATH."..".get_local_theme_path().$file);   
        }

        function theme($file, $data = array())
        {
            global $active_show;
            $data['user']   = $active_show->controller->get_user();
            // $get_builderengin =  &$active_show->controller->get_builderengine();
            $data['BuilderEngine'] = $active_show->controller->get_builderengine();
            //echo "<pre>";print_r($data);echo"</pre>";die();
            if($data['BuilderEngine']->get_templating_engine() == "smarty" && strpos(get_local_theme_path(), "dashboard") === FALSE)
            {
                //$active_show->controller->load->view("../..".get_local_theme_path().$file,$data);
                $active_show->controller->load->smart_view(APPPATH."..".get_local_theme_path().$file,$data);
            }
            else
                $active_show->controller->load->view("../..".get_local_theme_path().$file,$data); 
        }

        // parse constants ( site name, slogan, motto or whatever constant strings )
        function frontend($string, $data=array()) {


            global $active_show;

            $data['user']   = $active_show->controller->get_user();
            $data['BuilderEngine'] = $active_show->controller->get_builderengine();
            $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
            if ($_SERVER["SERVER_PORT"] != "80")
            {
                $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
            } 
            else 
            {
                $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
            }

            if($data['BuilderEngine']->is_editor_active() && ($data['user']->is_member_of("Administrators") || $data['user']->is_member_of("Frontend Editor") || $data['user']->is_member_of("Frontend Manager") ))
            {
                

                
     
                $data['url'] = $pageURL;
                $view = $active_show->controller->layout_system->load->view('site_editor', $data, true);

                $active_show->controller->module_parser->parse($view);
                return;
            }else

            {
                

            }

            if(!array_key_exists('contents', $data))
                $data['contents'] = $active_show->controller->load->view($string,$data,true);

            if($active_show->isolated) {
                $active_show->controller->load->vars($data);
                $view = $data['contents'];
                
            } else {
                if($data['BuilderEngine']->get_templating_engine() == "smarty" && strpos(get_local_theme_path(), "dashboard") === FALSE)
                    $view = $active_show->controller->load->smart_view(APPPATH."..".get_local_theme_path()."full.php",$data, true);
                    // was formerly full.tpl
                else
                    $view = $active_show->controller->load->view("../..".get_local_theme_path()."full.php",$data, true);

            }
            $active_show->controller->module_parser->parse($view);
            
            if(!isset($_GET['iframed']) && $active_show->controller->is_installed() && ($data['user']->is_member_of("Administrators") || $data['user']->is_member_of("Frontend Editor") || $data['user']->is_member_of("Frontend Manager") )){
                $ci =& get_instance();

                $parse = parse_url($pageURL);
                //print_r ($parse);
                if(strpos($_SERVER['REQUEST_URI'], '.html') !== FALSE) {
                    $editor_url = home_url("/editor".$_SERVER['REQUEST_URI']);
                } else {
                    $editor_url = home_url("/editor");
                }
                if($active_show->editor_tools_enabled)
                $ci->output->append_output("
                        
                        <style>
                        .be-edit-btn{
                            -webkit-background-clip: border-box;
                            -webkit-background-origin: padding-box;
                            -webkit-background-size: auto;
                            background-attachment: scroll;
                            background-clip: border-box;
                            background-color: #2d353c;
                            background-image: none;
                            background-origin: padding-box;
                            background-size: auto;
                            border-bottom-left-radius: 0px;
                            border-bottom-right-radius: 0px;
                            border-top-left-radius: 0px;
                            border-top-right-radius: 0px;
                            color: rgb(255, 255, 255);
                            cursor: pointer;
                            display: block;
                            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                            font-size: 18px;
                            font-style: italic;
                            height: 40px;
                            line-height: 28.799999237060547px;
                            padding-bottom: 7px;
                            padding-left: 9px;
                            padding-right: 9px;
                            padding-top: 7px;
                            position: fixed;
                            
                            
                            width: 135px;
                            z-index: 555555;
                        }
                        #trigger
                        {
                            right: -73px;
                            top: 37px;
                        }
                        #page-styler
                        {
                            right: -100px;
                            top: 87px;
                        }

                        #launch_editor {
                            display:none;
                        }
                        </style>
                        <script>
                            $(document).ready(function (){

                                $('#trigger').hover(function () {
                                    $(this).animate({right: '0px'}, 500);
                                },
                                function () {
                                    $(this).animate({right: '-73px'}, 500);
                                }
                                );
                                $('.delete-comment').click(function(e){
                                    e.preventDefault();
                                    var id = $(this).attr('data-id');
                                    $('#delete-comment input[name=comment_id]').val(id);
                                    $('#delete-comment').modal('show');
                                })
                            })
                        </script>

                        <a href='$editor_url'><i class=\"be-edit-btn\" id='trigger'>Editor Mode</i></a>
                      

                    ");
                }
        }

        function component($string) {
            global $active_show;
            if($active_show->controller->get_builderengine()->BuilderEngine->get_templating_engine() == "smarty" && strpos(get_local_theme_path(), "dashboard") === FALSE)
                $active_show->controller->load->smart_view(APPPATH."..".get_local_theme_path().$string.".php");
            else
                $active_show->controller->load->view("../..".get_local_theme_path().$string.".php");
            
        }

        function backend($string, $data=array()){
            global $active_show;
            $data['BuilderEngine'] = $active_show->controller->get_builderengine();
            if(isset($active_show->breadcrumb[0]))
                $data['breadcrumb'] = $active_show->breadcrumb;
            else{
                $uri = $active_show->controller->uri->segment(2);
                
                
                $name = explode("_", $uri);

                foreach($name as &$segment)
                {
                    $segment[0] = strtoupper($segment[0]);
                }
                $name = implode(" ", $name);
                $data['breadcrumb'][0]['name'] = $name;
                $data['breadcrumb'][0]['url'] = "";

                $uri = $active_show->controller->uri->segment(3);
                $name = explode("_", $uri);
                foreach($name as &$segment)
                {
                    $segment[0] = strtoupper($segment[0]);
                }
                $name = implode(" ", $name);
                
                $data['breadcrumb'][1]['name'] = $name;
                $data['breadcrumb'][1]['url'] = "";
            }

            $data['user']   = $active_show->controller->get_user() || FALSE;
            $active_show->controller->load->view("../..".get_local_theme_path().$string.".php",$data);
        }

        function user_backend($string, $data=array()){
            global $active_show;
            $data['BuilderEngine'] = $active_show->controller->get_builderengine();
            if(isset($active_show->breadcrumb[0]))
                $data['breadcrumb'] = $active_show->breadcrumb;
            else{
                $uri = $active_show->controller->uri->segment(2);

                $name = explode("_", $uri);

                foreach($name as &$segment)
                {
                    $segment[0] = strtoupper($segment[0]);
                }
                $name = implode(" ", $name);
                $data['breadcrumb'][0]['name'] = $name;
                $data['breadcrumb'][0]['url'] = "";

                $uri = $active_show->controller->uri->segment(3);
                $name = explode("_", $uri);
                foreach($name as &$segment)
                {
                    $segment[0] = strtoupper($segment[0]);
                }
                $name = implode(" ", $name);

                $data['breadcrumb'][1]['name'] = $name;
                $data['breadcrumb'][1]['url'] = "";
            }

            $data['user']   = $active_show->controller->get_user() || FALSE;
            $active_show->controller->load->view("../..".get_local_theme_path().$string.".php",$data);
        }
        function social_backend($string, $data=array()){
            global $active_show;
            $data['BuilderEngine'] = $active_show->controller->get_builderengine();
            if(isset($active_show->breadcrumb[0]))
                $data['breadcrumb'] = $active_show->breadcrumb;
            else{
                $uri = $active_show->controller->uri->segment(2);

                $name = explode("_", $uri);

                foreach($name as &$segment)
                {
                    $segment[0] = strtoupper($segment[0]);
                }
                $name = implode(" ", $name);
                $data['breadcrumb'][0]['name'] = $name;
                $data['breadcrumb'][0]['url'] = "";

                $uri = $active_show->controller->uri->segment(3);
                $name = explode("_", $uri);
                foreach($name as &$segment)
                {
                    $segment[0] = strtoupper($segment[0]);
                }
                $name = implode(" ", $name);

                $data['breadcrumb'][1]['name'] = $name;
                $data['breadcrumb'][1]['url'] = "";
            }

            $data['user']   = $active_show->controller->get_user() || FALSE;
            $active_show->controller->load->view("../..".get_local_theme_path().$string.".php",$data);
        }
        //disables the full wrapper class
        function disable_full_wrapper() {
            global $active_show;
            $active_show->isolated = true;
        }
        function disable_editor_tools() {
            global $active_show;
            $active_show->editor_tools_enabled = false;
        }


    }

    function is_installed()
    {
        global $active_show;
        return $active_show->controller->is_installed();
    }

    function get_header(){
        global $active_show;
        $active_show->controller->show->component("header");
    }

    function get_sidebar(){
        global $active_show;
        $active_show->controller->show->component("sidebar");
    }

    function get_option($option)
    {
        global $active_show;
        return $active_show->controller->BuilderEngine->get_option($option);
    }

    function get_footer(){
        global $active_show;
        $active_show->controller->show->component("footer");
    }

    function get_page_versions()
    {
        global $active_show;
        return $active_show->controller->get_page_versions();
    }

    function get_page_path(){
        global $active_show;
        return $active_show->controller->get_page_path();
    }
    function set_current_page_version_to_pending()
    {
        global $active_show;
        $controller =  &$active_show->controller;

        $page_version = $controller->versions->get_current_page_version();
        $controller->versions->set_version_pending($page_version);
    }
    function home_url($uri = '')
    {
        $link = build_link("site", $uri);
        if(strlen($link) > 0 && $link[strlen($link) - 1] == '/')
            $link = substr($link, 0, strlen($link) - 1);

        return $link;
    }
    function get_theme_path(){
        global $active_show;
        PC::base_url(base_url());
        if($active_show->frontend){
            return build_link("site","/themes/".$active_show->controller->BuilderEngine->get_frontend_theme())."/";
        }
        elseif($active_show->user_backend){
            return build_link("site","/themes/".$active_show->controller->BuilderEngine->get_user_backend_theme())."/";
        }
        elseif($active_show->social_backend){
            return build_link("site","/themes/".$active_show->controller->BuilderEngine->get_social_backend_theme())."/";
        }
        else{
            return build_link("site","/themes/".$active_show->controller->BuilderEngine->get_backend_theme())."/";
        }
    }
    function get_logo_path()
    {
        global $active_show;
        if($url = $active_show->controller->BuilderEngine->get_option('logo_img')){
            if(file_exists(APPPATH.'..'.$url))
                return $active_show->controller->BuilderEngine->get_option('logo_img');
            else
                return get_theme_path().'assets/img/builderengine-logo.png';
        }else
            return get_theme_path().'assets/img/builderengine-logo.png';
    }
    function get_local_theme_path(){

        global $active_show;
        PC::base_url(base_url());
        if($active_show->frontend){
            return "/themes/".$active_show->controller->BuilderEngine->get_frontend_theme()."/";
        }
        elseif($active_show->user_backend){
            return "/themes/".$active_show->controller->BuilderEngine->get_user_backend_theme()."/";
        }
        elseif($active_show->social_backend){
            return "/themes/".$active_show->controller->BuilderEngine->get_social_backend_theme()."/";
        }
        else{
            return "/themes/".$active_show->controller->BuilderEngine->get_backend_theme()."/";
        }
    }

    function get_modules_url(){
        return base_url()."/modules/".$active_show->controller->BuilderEngine->get_backend_theme()."/";
    }

    function build_link($type, $relative_href)
    {
        if(strlen($relative_href) > 0 && $relative_href[0] != '/')
            $relative_href = '/'.$relative_href;

        if(array_key_exists('HTTP_MOD_REWRITE', $_SERVER) && $_SERVER['HTTP_MOD_REWRITE'] == "On")
            $href_prefix = "";
        else
            $href_prefix = "/index.php?";

        switch($type)
        {
            case "site":
                $url = base_url($href_prefix.$relative_href);
                break;
            case "module":
                $url = base_url($href_prefix.$relative_href);
                break;
            case "module_admin":
                $url = base_url($href_prefix."/admin".$relative_href);
                break;
            case "admin":
                $url = base_url($href_prefix."/admin".$relative_href);
                break;
            case "user":
                $url = base_url($href_prefix."/user".$relative_href);
                break;

        }
        return $url;

    }
    function url($relative_href)
    {

        return build_link('site', $relative_href);
    }
    function href($type, $relative_href)
    {
        return "href=\"".build_link($type, "/".$relative_href)."\"";
        //return "href=\"#\" onclick=\"$('#content').load('".build_link($type, $relative_href)." .wrapper, script', function () { $(document).trigger('onload'); }); \"";
        //return "href=\"#\" onclick=\"ajax_load('#content', '".build_link($type, $relative_href)."?ajax=true');\"";
    }

    function get_links($tag = "")
    {
        global $active_show;
        $links = $active_show->controller->get_links($tag);
        foreach($links as $key => $link)
        {
            $links[$key]->target = str_replace("%site_root%", home_url('/'), $link->target);
            if($link->parent != 0)
                unset($links[$key]);
        }

        foreach($links as $key => $link)
        {
            if($link->childs)
                foreach($link->childs as &$sublink)
                {
                    $sublink = (object)$sublink;
                    $sublink->target = str_replace("%site_root%", home_url('/'), $sublink->target);
                }
        }
        return $links;
    }
