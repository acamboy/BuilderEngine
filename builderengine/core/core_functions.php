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
    
    function includeRecurse($dirName) { 
        if(!is_dir($dirName)) 
            return false;          
        $dirHandle = opendir($dirName); 
        while(false !== ($incFile = readdir($dirHandle))) { 
            if($incFile != "." && $incFile != "..") { 
                if(is_file("$dirName/$incFile")) 
                    include_once("$dirName/$incFile"); 
                elseif(is_dir("$dirName/$incFile")) 
                    includeRecurse("$dirName/$incFile"); 
            } 
        } 
        closedir($dirHandle); 
    }
    
    function check_writable_recurse($dirName) {
        if($dirName[0] == ".")
            return true;
        if(!is_dir($dirName)) 
            return false;          
        $dirHandle = opendir($dirName); 
        while(false !== ($incFile = readdir($dirHandle))) { 

            if($incFile != "." && $incFile != "..") { 
                if(is_file("$dirName/$incFile")) 
                    if(!is_writable("$dirName/$incFile"))
                        return false; 
                elseif(is_dir("$dirName/$incFile")) 
                    if(!check_writable_recurse("$dirName/$incFile"))
                        return false; 
            } 
        }
        echo $incFile; 
        return true;
    }
    function check_php_version($required_version)
    {
        $current_version = phpversion();

        return version_compare($current_version, $required_version, '>=');
    }

    function get_php_version()
    {
        return phpversion();
    }

    function get_active_user_id()
    {
        $CI = & get_instance();
        $CI->load->library('session');
        return $CI->session->userdata('user_id');
    }

    /*
    *sometimes FCKeditor wants to add \r\n, so replace it with a space
    *sometimes FCKeditor wants to add <p>&nbsp;</p>, so replace it with nothing
    */
    function ChEditorfix($value){
        $order   = array("\\r\\n", "\\n", "\\r", "<p>&nbsp;</p>");
        $replace = array(" ", " ", " ", "");
        $value = str_replace($order, $replace, $value);
        if(strpos($value, 'src')){
            return preg_replace('/(\\\")/', '"',$value );
        }else{
            return $value;
        }
    }