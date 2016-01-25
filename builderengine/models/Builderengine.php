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

/* 
 * TODO: Major cleanup and optimization
 */
global $BuilderEngine;
$BuilderEngine = null;
    class BuilderEngine extends CI_Model {
        private $options = array();   
        private $global_blocks = false;
        private $user;
        private static $page_path = false;
        private static $is_editor_active = false;
        function set_blocks_global($bool)
        {
            $this->global_blocks = $bool;
        }
        function is_public_version()
        {
            return $this->config->item("public_version") == true;
        }
        function get_blocks_global() { return $this->global_blocks; }
        function __construct()
        {
            parent::__construct(); 
            $this->load_settings();
//            $this->remove_old_uploaded_files();
            global $active_show;
            $this->user = &$active_show->controller->user;

            global $BuilderEngine;
            if($BuilderEngine == null){
                $BuilderEngine = $this;
            }
        }
        public function get_templating_engine()
        {
            if($this->config->item("templating_engine") == "smarty")
                return "smarty";
            else
                return "legacy";
        }
        public function is_editor_active()
        {
            return self::$is_editor_active;
        }
        public function set_editor_active()
        {
            self::$is_editor_active = true;
        }
        public function set_page_path($page_path)
        {
            self::$page_path = $page_path;
            $this->versions->load_page_blocks();
        }
        public function get_page_path()
        {
            if(!self::$page_path)
                return "{error:no_path_specified}";
            return self::$page_path;
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

        function load_settings()
        {    
            global $active_show;

            if(!$active_show->controller->is_installed())
                return;
            $result = $this->db->get("options");
            $result = $result->result();
            foreach ($result as $option)
            {
                $this->options[$option->name] = $option->value;
            }
              
        }

        //Alias for handle_head() for backwards compatibility
        function integrate_builderengine_styles()
        {
            $this->handle_head();
        }
        function integrate_builderengine_js($options = array())
        {
            $this->handle_foot($options);
        }
        function generate_script_url($path)
        {
            return "<script src=\"".home_url($path)."\"></script>";
        }
        function include_script($path)
        {
            echo $this->generate_script_url($path);
        }
        function handle_head()
        {
            echo "
                <script type=\"text/javascript\">
                    site_root = \"".home_url('')."\";
                    theme_root = \"".get_theme_path()."\";
                </script>
            ";
            EventManager::fire('be_head');
            $this->_integrate_builderengine_styles();
        }
        function handle_foot($options = array())
        {
            $this->_integrate_builderengine_js($options);
            EventManager::fire('be_foot');
            echo "<script>";
            EventManager::fire('be_enqueue_scripts');
            echo "</script>";
        }
        function _integrate_builderengine_styles()
        {?>
            <script src="<?php echo home_url("/builderengine/public/js/jquery.js")?>"></script>
            <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" />
            <link href="http://vitalets.github.io/angular-xeditable/dist/css/xeditable.css" rel="stylesheet" />
            <link rel='stylesheet' id='font-awesome-4-css'  href="<?=base_url('/builderengine/public/css/font-awesome.css?ver=4.0.3')?>" type='text/css' media='all' />

            <?php 
            if(is_installed()):?>
            <?php

            $block = new Block('be_body_styler_'.$this->BuilderEngine->get_option('active_frontend_theme'));
            $block->set_global(true);
            if(!$block->load())
                $block->save();
            ?>
            
            <style>
            body
            {
                <?=$block->build_style(true)?>
            }
            <?php endif;?>
            #virtual-block-holder{
                position: absolute;
                z-index:999;
            }
            .area {
                position: relative;
                display: inline-block;
                min-width: 50px;
                min-height: 25px;
            }

                #admin-window {
                    z-index: 999999 !important;
                }
                .block-children {
                    /*min-height: 20px;*/
                    position:relative;
                    /*display: inline-block;*/
                    /*float: left;*/
                }
                .block {
                    position: relative;
                    /*float: left;*/
                    /*display: inline-block;*/
                }
                .placeholder {
                    border: 1px dotted #888;
                    
                    -webkit-box-shadow: 0px 0px 10px #888;
                    -moz-box-shadow: 0px 0px 10px #888;
                    box-shadow: 0px 0px 10px #888;
                }
                .ui-sortable-placeholder {
                    border: 2px dotted #333;
                    -webkit-box-shadow: 0px 0px 10px #888;
                    -moz-box-shadow: 0px 0px 10px #888;
                    box-shadow: 0px 0px 10px #888;
                    visibility: visible !important;
                }
            </style>

        <?php
        }
        
        function _integrate_builderengine_js($options = array())
        {
            global $active_show;
            $user = $active_show->controller->user;
            if(!isset($options['include_jquery']) || $options['include_jquery'] === true)
                echo '<script src="'.home_url("/builderengine/public/js/jquery.js").'"></script>';
            ?>

            <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" ></script>
            
            <script src="<?php echo home_url("/builderengine/public/js/editor/ckeditor.js")?>"></script>

            <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.0.8/angular.min.js"></script>
            <script src="http://vitalets.github.io/angular-xeditable/dist/js/xeditable.js"></script>
            <script src="<?php echo home_url("/builderengine/public/js/absolute-json.js")?>"></script>

            
            <script type="text/javascript">
                var page_path = "<?=get_page_path()?>";
                var theme_path = "<?=get_theme_path()?>";
                var blocks_for_reload = {};
                var disable_auto_block_reload = false;
                var getting_block = false;

                var has_focus = true;
                var var_editor_mode = "";

            </script>
            <link rel="stylesheet" type="text/css" href="<?php echo home_url("/builderengine/public/editor/css/main.css?4")?>" />
			

            <script type="text/javascript">

                $(document).ready(function(){
                    if(window.parent.page_url_change)
                    window.parent.page_url_change(page_path);
                    jQuery(document).bind('editor_mode_change',  function (event, action){
                        if(action == "editModeEnable")
                            var_editor_mode = "edit";
                        if(action == "blockStyleModeEnable")
                            var_editor_mode = "style";

                        console.log('Received event '+action);
                        if(action == "blockStyleModeEnable" || action == "editModeEnable" || action == 'resizeModeEnable' || action == 'moveModeEnable' || action == 'addBlockModeEnable' || action == 'deleteBlockModeEnable')
                        {
                            disable_auto_block_reload = true;
                        }

                        if(action == "blockStyleModeDisable" || action == "editModeDisable" || action == 'resizeModeDisable' || action == 'moveModeDisable' || action == 'addBlockModeDisable' || action == 'deleteBlockModeDisable')
                        {
                            var_editor_mode = "";
                            disable_auto_block_reload = false;
                        }
                    });
                    <?php  $copied_block = $user->get_session_data("copied_block");
                    if($copied_block):?>
                        $("#paste-block-button").parent().removeClass("disabled");
                    <?php endif;?>  


                    $("#editor-holder").css('display','none');
                    <?php if($user->is_member_of("Administrators") || $user->is_member_of("Frontend Editor") || $user->is_member_of("Frontend Manager")): ?>
                    //$("body").css("padding-top", "45px");

                   
                    <?php endif; ?>
                    //$("html").attr('ng-app','');
                    //$.getScript("http://ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js");
                });
            </script>
            <script src="<?php echo home_url("/builderengine/public/editor/js/remove_block.js")?>"></script>
            <script src="<?php echo home_url("/builderengine/public/editor/js/undo_block.js")?>"></script>
            <script src="<?php echo home_url("/builderengine/public/editor/js/resize.js")?>"></script>
            <script src="<?php echo home_url("/builderengine/public/editor/js/admin.js?v4")?>"></script>
            <script src="<?php echo home_url("/builderengine/public/editor/js/main.js?v4")?>"></script>
            <script src="<?php echo home_url("/builderengine/public/editor/js/edit_off_sorts.js")?>"></script>
            <script src="<?php echo home_url("/builderengine/public/js/frontend-editor.js")?>"></script>
            <script src="<?php echo home_url("/builderengine/public/js/bootstrap-wysihtml5.js")?>"></script>
	
				
            <?php
        }
        function get_option($name)
        {
            if (array_key_exists($name, $this->options) )
                return $this->options[$name];
            else
                return "";
        }
        function set_option($name, $value, $synch_db = true)
        {
            if($synch_db)
                if (array_key_exists($name, $this->options) )
                {
                    $this->db->where(array('name' => $name));
                    $this->db->update('options', array('value' => $value));
                }else{
                    $data = array(
                        'name' => $name,
                        'value' => $value
                    );
                    
                    $this->db->insert('options', $data);
                }
            $this->options[$name] = $value;
        }
        
        function get_frontend_theme()
        {
            return $this->get_option('active_frontend_theme');
        }
        function get_backend_theme()
        {
            return $this->get_option('active_backend_theme');
        }
        function get_user_backend_theme()
        {
            return $this->get_option('active_user_backend_theme');
        }
        
        function get_social_backend_theme()
        {
            return $this->get_option('active_social_backend_theme');
        }
        function activate_frontend_theme($theme)
        {
            $this->set_option("active_frontend_theme", $theme);
        }
        function activate_backend_theme($theme)
        {
            $this->set_option("active_backend_theme", $theme);
        }

        function register_visit($page_path)
        {
            $data = array(
                "ip"        => $_SERVER['REMOTE_ADDR'],
                "page"      => $page_path,
                "date"      => date("Y-m-d"),
                "timestamp" => time()
                );
            $this->db->insert("visits", $data);

        }
        function get_online_site_visitors($seconds = 300)
        {
            $this->db->select("COUNT(DISTINCT ip) as visitors");
            $time = time() - $seconds;
            $this->db->where("`timestamp` >= '$time'");
            $query = $this->db->get("visits");
            $result = $query->result();
            return $result[0]->visitors;
        }
        function get_total_site_visits($from, $to, $type)
        {
            global $active_show;

            if(!$active_show->controller->is_installed())
                return;

            switch($type)
            {
                case "all":
                    $this->db->select("count(*) as count");

                    $this->db->where("timestamp > $from");
                    $this->db->where("timestamp < $to");

                    $query = $this->db->get("visits");
                    $result = $query->result();
                    return intval($result[0]->count);
                    break;

                case "unique":
                    $this->db->select("count(DISTINCT `ip`) as count");

                    $this->db->where("timestamp > $from");
                    $this->db->where("timestamp < $to");
                    //$this->db->group_by("date");

                    $query = $this->db->get("visits");
                    $result = $query->result();
                    return intval($result[0]->count);
                    break;
            }
        }

        function get_site_visits($type, $days, $single_day = false)
        {
            global $active_show;

            if(!$active_show->controller->is_installed())
                return;
            
            $distinct = false;
            switch($type){
                case "unique":
                    $distinct = true;

                case "all":
                for($i = 0; $i < $days; $i++)
                {
                    $visits[$i] = 0;
                    if($single_day)
                        break;
                }

                for($i = 0; $i < $days; $i++){
                    $date = date("Y-m-d",mktime(0,0,0,date("m"),date("d") - $i));
   
                    if($distinct)
                        $this->db->select("COUNT(DISTINCT `ip`) as visits");
                    else
                        $this->db->select("COUNT(*) as visits");
                    if(true)
                        $this->db->where("date = '$date'");   
                    else
                        $this->db->where("date >= '$date'");
                    $this->db->order_by("date DESC");
                    
                    $query = $this->db->get("visits");
                    $result = $query->result();
                    $visits[$i] = $result[0]->visits;                     
                }
                if(count($visits) == 1)
                    return $visits[0];
                else
                    return $visits;
                break;
            }
        }

         function getuserscount($today = NULL){
            $this->db->select("count(DISTINCT `ip`) as count");
             if($today) {
                 $date = date("Y-m-d");
                 $this->db->where("date = '$date'");
             }
            $query = $this->db->get("visits");
            $result = $query->result();
            return intval($result[0]->count);
        }

        function getVisitsByIp($ip){
            $this->db->select("count(`ip`) as count");
            $this->db->where("ip = '$ip'");
            $query = $this->db->get("visits");
            $result = $query->result();
            return $result[0]->count;
        }

    function getcountries(){
        $this->db->select("*");
        $query = $this->db->select('count(ip) count');
        $query = $this->db->group_by('ip');
        $query = $this->db->order_by('count DESC');
        $query = $this->db->limit(10);
        $query = $this->db->get("visits");

        $result = $query->result();
        return $result;
    }

         function todayvisitorscount(){
            $date = date("Y-m-d");
            $this->db->select("count(*) as countVisits");
            $this->db->where("date = '$date'");
            $query = $this->db->get("visits");
            $result = $query->result();
            return $result[0]->countVisits;
        }

        function lastweekvisitorscount(){
            $previous_week = strtotime("-1 week +1 day");
            $start_week = strtotime("last sunday midnight",$previous_week);
            $end_week = strtotime("next saturday",$start_week);
            $start_week = date("Y-m-d",$start_week);
            $end_week = date("Y-m-d",$end_week);
            $datelastweek = $start_week;
            $date = $datelastweek;
            $this->db->select("count(*) as countVisits");
            $this->db->where("date = '$date'");
            $query = $this->db->get("visits");
            $result = $query->result();
            return $result[0]->countVisits;
        }

        function getBlogCount()
        {
            return $this->db->count_all_results('blog_posts');
        }

        function getBlogCommentsCount(){
            return $this->db->count_all_results('blog_comments');
        }
    }
?>