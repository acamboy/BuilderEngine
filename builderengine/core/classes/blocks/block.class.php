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

// To be updated
 class Block{
    private $html;
    private $options = array();
    public $blocks   = array();

    public $name = null;
    protected $data = array();

    protected $output = true;

    protected $BuilderEngine = null;
    protected $db = null;
    private $layout_system = null;
    private $is_new_block = false;
    private $versions;

    protected $global = false;
    public $type = 'generic';
    private $loaded = false;
    private $force_data_modification = false;
    private $id = 0;
    // System Functions Begin
    function __construct($name) {
        $this->name = $name;
        global $active_show;
        $this->BuilderEngine = &$active_show->controller->BuilderEngine;

        $ci =& get_instance();
        $ci->load->model('versions');
        $this->versions =& $ci->versions;

        $this->db =& $ci->db;

        $ci->load->module('layout_system');
        $this->layout_system = &$ci->layout_system;

        $this->defaults();

    }
    public function is_new()
    {
        return $this->is_new_block;
    }
    public function auto_refresh($interval)
    {
        echo "
        <script>
            if(!('{$this->name}' in blocks_for_reload))
            {
                blocks_for_reload['{$this->name}'] = true;
                setInterval(function(){reload_block('{$this->name}', page_path, false)},{$interval});
            }
        </script>";
    }
    public function set_type($type)
    {
        $this->type = $type;
    }
    public function set_name($name)
    {
        $this->name = $name;
    }
     public function set_id($id)
     {
         $this->id = $id;
     }
    public function type()
    {
        return $this->type;
    }
    public function save_content($content)
    {
        if($this->type != 'generic')
        {
            include_once("blocks/".$this->type."/".$this->type.".php");

            $classname = $this->type."_block_handler";
            $handler = new $classname();
            $handler->set_block($this);
            return $handler->save_content($content);
        }else
            $this->set_data('content', $content, true);
    }
    public function generate_admin($menu = '', $active_menu = '')
    {
        if(true /*$this->type != 'generic'*/)
        {
            include_once("blocks/".$this->type."/".$this->type.".php");

            $classname = $this->type."_block_handler";
            $handler = new $classname();
            $handler->set_block($this);
            if($menu == 'styler')
                if($active_menu != '')
                    return $handler->generate_style($active_menu);
                else
                    return $handler->generate_style();
            else
                return $handler->generate_admin();
        }else
            echo "Type is ".$this->type;
    }
    private function generate_content()
    {
        if(true /*$this->type != 'generic'*/)
        {
            include_once("blocks/".$this->type."/".$this->type.".php");

            $classname = $this->type."_block_handler";
            $handler = new $classname();
            $handler->set_block($this);
            return $handler->generate_content();
        }
    }
    private function output_admin_options()
    {
        if($this->type != 'generic')
        {
            include_once("blocks/".$this->type."/".$this->type.".php");

            $classname = $this->type."_block_handler";
            $handler = new $classname();
            $handler->set_block($this);
            $handler->load_options();
            return $handler->output_admin_options();
        }
    }
    public function force_data_modification()
    {
        $this->force_data_modification = true;
    }
    private function defaults()
    {
        if($this->loaded){
            return;
        }
        $this->set_data('html','{content} {elements}');
        $this->html = $this->data('html');
        $this->set_resizable(true);
        $this->set_size('span12');
        $this->set_data('css_attributes', array());
    }
    public function css($attribute)
    {
        $css_attributes = $this->data('style');
        if(isset($css_attributes[$attribute]))
            return $css_attributes[$attribute];
        else
            return false;
    }

    public function set_css($attribute, $value)
    {
        $css_attributes = $this->data('style');
        $css_attributes[$attribute] = $value;
        $this->set_data('style', $css_attributes);
    }

    public function load()
    {
        if($this->loaded)
            return true;
        $this->loaded = $this->layout_system->blocks->load($this);
        if(!$this->loaded){

            $this->is_new_block = true;
        }
        return $this->loaded;
    }
    public function data($key)
    {
        if(!isset($this->data[$key]))
            return null;
        else
            return $this->data[$key];
    }

    public function set_data($key, $value, $force = false)
    {
//        if($this->loaded && !$force && !$this->force_data_modification){
//            return;
//        }
        $this->data[$key] = $value;
    }
    public function set_option($key, $value)
    {
        $this->options[$key] = $value;
    }
    public function option($key)
    {
        return $this->options[$key];
    }

    public function output($bool)
    {
      $this->output = $bool;
    }

    public function is_resizable()
    {
      return $this->data("resizable");
    }
    public function set_resizable($bool)
    {
      $this->set_data("resizable", $bool);
    }

    public function set_size($size)
    {
        $this->set_data('size', $size);
    }
    public function size()
    {
        return $this->data('size');
    }
    // Edit blocks 2.0
    public function get_initial_settings()
    {
        include_once("blocks/".$this->type."/".$this->type.".php");

        $classname = $this->type."_block_handler";
        $handler = new $classname();
        $handler->set_block($this);
        return $handler->set_initial_values_if_empty();
    }
    // edit end
    public function show()
    {
        $freeModeClass = '';
        if(!$this->load())
            $this->is_new_block = true;

        $content = $this->data('content');

        if(true /*$this->type != 'generic' && $this->type != ""*/){

            $content = $this->generate_content();
        }

        $editor = $this->data('block-editor');

        if($this->type == 'generic' || ($editor != null && $editor = 'inline-text-editor'))
            $block_editor = 'ckeditor';
        else
            $block_editor = 'custom';


        //$block_editor = 'ckeditor';

        if ($this->is_new_block){
            PC::WARNING("This is new block - saving ".$this->name);
            $this->save();
        }

        $classes = "";

        if($this->is_resizable())
            $classes .= " resizable ".$this->size()." ";

        $block_content = "<div class='block-content'
        id='block-content-id-{$this->name}'
        block-type='{$this->type}'";
        if($block_editor != 'ckeditor')
            $block_content .= "block-editor='{$block_editor}'";
        $block_content .= "
        block-name='{$this->name}'>
        ".$content."</div>";
        $this->children_holder_classes = "";

        switch($this->type)
        {
            case "header":
                $this->html .= '<div class="block-controls section-block-'.$this->id.'">
                                    <div class="block-controls-inner panel-heading-btn">
                                        <p class="new-block-clarification" style="margin-left: 45% !important;">Right-click for options</p>
										<a rel="tooltip" data-placement="top" title="Remove" href="#close" class="remove btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
										<a rel="tooltip" data-placement="top" title="Minimize / Maximize" class="collapse-element btn btn-xs btn-warning"><i class="fa fa-minus"></i></a>
                                        ';
                $this->html .= $this->output_admin_options();
                $this->html .= "    </div>
                                </div>";
                $classes .= " be-header-block be-container-block";
                $this->children_holder_classes = " header-children ";

                break;
            case "page":
                $this->html .= '<div class="block-controls section-block-'.$this->id.'">
                                   <div class="block-controls-inner panel-heading-btn">
                                        <p class="new-block-clarification" style="margin-left: 45% !important;">Right-click for options</p>
										<a rel="tooltip" data-placement="top" title="Remove" href="#close" class="remove btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
										<a rel="tooltip" data-placement="top" title="Minimize / Maximize" class="collapse-element btn btn-xs btn-warning"><i class="fa fa-minus"></i></a>
                                        ';
                $this->html .= $this->output_admin_options();
                $this->html .= "   </div>
                                </div>";
                $classes .= " be-page-content-block be-page-block be-container-block";
                $this->children_holder_classes = " page-children ";
                break;

            case "footer":
                $this->html .= '<div class="block-controls section-block-'.$this->id.'">
                                    <div class="block-controls-inner panel-heading-btn">
                                        <p class="new-block-clarification" style="margin-left: 45% !important;">Right-click for options</p>
										<a rel="tooltip" data-placement="top" title="Remove" href="#close" class="remove btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
										<a rel="tooltip" data-placement="top" title="Minimize / Maximize" class="collapse-element btn btn-xs btn-warning"><i class="fa fa-minus"></i></a>
                                        ';
                $this->html .= $this->output_admin_options();
                $this->html .= "   </div>
                                </div>";
                $classes .= " be-footer-content-block be-footer-block be-container-block";
				$this->children_holder_classes = " row-children ";
                break;
            case "row":
                $this->html .= '<div class="block-controls section-block-'.$this->id.'">
                                    <div class="block-controls-inner panel-heading-btn">
                                       <p class="new-block-clarification" style="margin-left: 45% !important;">Right-click for options</p>

                                       <a rel="tooltip" data-placement="top" title="Remove" href="#close" class="remove btn btn-xs btn-danger"><i class="fa fa-times"></i></a>

                                       <a rel="tooltip" data-placement="top" title="Minimize / Maximize" class="collapse-element btn btn-xs btn-warning"><i class="fa fa-minus"></i></a>

                                        <span rel="tooltip" data-placement="top" title="Move" class="drag btn btn-xs btn-white"><i class="fa fa-arrows"></i></span>
                                        ';
                $this->html .= $this->output_admin_options();
                $this->html .= '
                                    </div>
                                </div>';
                $this->children_holder_classes = " row-children ";
                $classes .= " be-row-block row";
                break;

            case "column":
                $classes = " be-column-block";
                $this->html .= '<div class="block-controls section-block-'.$this->id.'">
                                    <div class="block-controls-inner panel-heading-btn">

                                       <p class="new-block-clarification" style="margin-left: 45% !important;">Right-click for options</p>
                                       <a rel="tooltip" data-placement="top" title="Remove" href="#close" class="remove btn btn-xs btn-danger"><i class="fa fa-times"></i></a>

                                        <a rel="tooltip" data-placement="top" title="Minimize / Maximize" class="collapse-element btn btn-xs btn-warning"><i class="fa fa-minus"></i></a>

                                        <span rel="tooltip" data-placement="top" title="Move" class="drag btn btn-xs btn-white"><i class="fa fa-arrows"></i></span>
                                    </div>
                                </div>';
                $this->children_holder_classes = " column-children ";
                break;
            case "generic":
                $freeModeClass = 'freeMode';
                $classes = " be-content-block generic-block-".$this->id;
                $this->html .= '<div class="block-controls">
                                   <div class="block-controls-inner panel-heading-btn">
                                       <p class="new-block-clarification" style="margin-left: 45% !important;">Right-click options</p>

                                       <a rel="tooltip" data-placement="top" title="Remove" href="#close" class="remove btn btn-xs btn-danger"><i class="fa fa-times"></i></a>

                                        <span rel="tooltip" data-placement="top" title="Move" class="drag btn btn-xs btn-white"><i class="fa fa-arrows"></i></span>

                                    <a rel="tooltip" data-placement="top" title="Undo" href="#undo" class="undo btn btn-xs btn-white"><i class="fa fa-undo"></i></a>
                                    </div>
                                </div>';
                break;
            case "content":
                $block_type_class = str_replace('_', '-', $this->type).'-block';
                if($this->type != 'container')
                    $block_type_html_class = str_replace('_', '-', $this->type);
                else
                    $block_type_html_class = '';
                echo '
                    <style>
                    .editor-mode-active .'.$block_type_class.':before
                    {
                        content: "'.ucfirst(str_replace('_', ' ', $this->type)).'";
                    }
                    </style>
                ';
                $classes = $block_type_class.' '.$block_type_html_class;
                $this->html .= '<div class="block-controls section-block-'.$this->id.'">
                                    <div class="block-controls-inner panel-heading-btn">
                                        <p class="new-block-clarification" style="margin-left: 45% !important;">Right-click for options</p>

                                        <a rel="tooltip" data-placement="top" title="Remove" href="#close" class="remove btn btn-xs btn-danger"><i class="fa fa-times"></i></a>

                                        <a rel="tooltip" data-placement="top" title="Minimize / Maximize" class="collapse-element btn btn-xs  btn-warning" data-click="panel-collapse" data-original-title="" title=""><i class="fa fa-minus"></i></a>

                                        <span rel="tooltip" data-placement="top" title="Move" class="drag drag-content btn btn-xs btn-white"><i class="fa fa-arrows"></i></span>';

                $this->html .= '
                                        ';

                $this->html .= $this->output_admin_options();

                $this->html .= "</div>
                                </div>";
                $this->children_holder_classes = " content-children ";
                break;

            case "container":
                $block_type_class = str_replace('_', '-', $this->type).'-block';
                if($this->type != 'container')
                    $block_type_html_class = str_replace('_', '-', $this->type);
                else
                    $block_type_html_class = '';
                echo '
                    <style>
                    .editor-mode-active .'.$block_type_class.':before
                    {
                        content: "'.ucfirst(str_replace('_', ' ', $this->type)).'";
                    }
                    </style>
                ';
                $classes = $block_type_class.' '.$block_type_html_class;
                $this->html .= '<div class="block-controls section-block-'.$this->id.'">
                                    <div class="block-controls-inner panel-heading-btn">
                                        <p class="new-block-clarification" style="margin-left: 45% !important;">Right-click for options</p>

                                        <a rel="tooltip" data-placement="top" title="Remove" href="#close" class="remove btn btn-xs btn-danger"><i class="fa fa-times"></i></a>

                                        <a rel="tooltip" data-placement="top" title="Minimize / Maximize" class="collapse-element btn btn-xs  btn-warning" data-click="panel-collapse" data-original-title="" title=""><i class="fa fa-minus"></i></a>

                                        <span rel="tooltip" data-placement="top" title="Move" class="drag drag-container btn btn-xs btn-white"><i class="fa fa-arrows"></i></span>';

                $this->html .= $this->output_admin_options();

                $this->html .= "</div>
                                </div>";
                $this->children_holder_classes = " container-children ";
                break;
            default:
                $freeModeClass = 'freeMode';
                $block_type_class = str_replace('_', '-', $this->type).'-block';
                if($this->type != 'container')
                    $block_type_html_class = str_replace('_', '-', $this->type);
                else
                    $block_type_html_class = '';
                echo '
                    <style>
                    .editor-mode-active .'.$block_type_class.':before
                    {
                        content: "'.ucfirst(str_replace('_', ' ', $this->type)).'";
                    }
                    </style>
                ';
                $classes = $block_type_class.' '.$block_type_html_class;
                $this->html .= '<div class="block-controls">
                                    <div class="block-controls-inner panel-heading-btn">
                                        <p class="new-block-clarification" style="margin-left: 45% !important;">Right-click on block content for options</p>

                                        <a rel="tooltip" data-placement="top" title="Remove" href="#close" class="remove btn btn-xs btn-danger"><i class="fa fa-times"></i></a>

                                        <a rel="tooltip" data-placement="top" title="Minimize / Maximize" class="collapse-element btn btn-xs  btn-warning" data-click="panel-collapse" data-original-title="" title=""><i class="fa fa-minus"></i></a>

                                        <span rel="tooltip" data-placement="top" title="Move" class="drag btn btn-xs btn-white"><i class="fa fa-arrows"></i></span>';



                                        $this->html .= '
                                        <a rel="tooltip" data-placement="top" title="Undo" href="#undo" class="undo btn btn-xs btn-white"><i class="fa fa-undo"></i></a>';

                $this->html .= $this->output_admin_options();

                $this->html .= "</div>
                                </div>";
                break;
        }

        //$block_content =  "Content ".$this->html;
        if( $this->type == 'row'
            || $this->type == 'column'
            || $this->type == 'footer'
            || $this->type == 'header'
            || $this->type == 'page'
            || $this->type == 'content')
            $this->html = preg_replace('/{elements}/', $block_content, $this->html, 1);
        $this->html = preg_replace('/{content}/', $block_content, $this->html, 1);

        $this->include_nested_elements();


        $css_attributes = $this->data('css_attributes');
        $arr = $this->data('style');
        if(isset($arr['custom_classes']))
            $add_classes = $arr['custom_classes'];
        else
            $add_classes = "";

        $style = $this->build_style();

        $html_id = $this->data('html_id');
        $html_id_string = "";

        if($html_id != null)
        {
            $html_id_string = " id=\"$html_id\" ";
        }

        $output = "<div $html_id_string block-type='{$this->type}' class='block ".$freeModeClass." {$classes} {$add_classes} {$this->get_css_classes()}' style=\"{$style}\" name='{$this->name}'>".$this->block_control_bar().$this->html."</div>";

        $output = str_replace("%site_root%", home_url('/'), $output);
        $output = str_replace("%theme_root%", get_theme_path(), $output);

        if($this->output){
            echo $output;
        }
        else{
            return $output;
        }

    }
     public function block_control_bar()
     {

     }
    public function build_style($force = true)
    {
        $style_arr = $this->data("style");
        if(!$style_arr)
            return "";

        unset($_POST['background-image_override']);
        unset($_POST['background-color_override']);
        unset($_POST['border_override']);
        unset($_POST['font-color_override']);

        if(isset($style_arr['font-family-2'])){
            $style_arr['font-family'] .= ", ".$style_arr['font-family-2'];
            unset($style_arr['font-family-2']);
        }

        if(isset($style_arr['background-image'])){
            if(strpos($style_arr['background-image'], 'url(') === FALSE)
                $style_arr['background-image'] = " url(".$style_arr['background-image'].")";
            else
                $style_arr['background-image'] = $style_arr['background-image'];
        }

        if(isset($style_arr['custom'])){
            $custom_style = str_replace('\n', '', $style_arr['custom']);
            unset($style_arr['custom']);
        }else
            $custom_style = "";

        if(isset($style_arr['custom_classes']))
            unset($style_arr['custom_classes']);

        $style = "";
        foreach($style_arr as $attr => $value)
        {
            if($value == "")
                continue;
            if($force)
                $style .= $attr.": ".$value." !important; ";
            else
                $style .= $attr.": ".$value."; ";
        }
        return $style.$custom_style;
    }
    private function include_nested_elements()
    {
        $output = "";
        foreach($this->blocks as $block)
        {
            $block->output(false);
            $output .= $block->show();
        }
        if(strpos($this->html, '{elements}') === FALSE)
        {
            $this->html .= "{elements}";
        }
        $this->html = preg_replace('/{elements}/', "<div class='block-children block-children-connectable row-fluid {$this->children_holder_classes}' sortable='true' block-name='{$this->name}'>".$output."</div>", $this->html, 1);
    }
    public function has_css_class($class)
    {
        $style = $this->data('style');
        if(!$style)
            return false;

        return strpos($style, " ".$class." ") !== false;
    }
    public function add_css_class($class)
    {
        $style = $this->data('style');
        if(!$style)
            $style = array();

        if(!isset($style['custom_classes']))
            $style['custom_classes'] = "";

        $style['custom_classes'] .= " ".$class." ";


        $this->set_data('style', $style);
    }
    public function remove_css_class($class)
    {
        $style = $this->data('style');
        if(!$style)
            return;

        if(!isset($style['custom_classes']))
            return;

        $style['custom_classes'] = str_replace(" ".$class." ", "", $style['custom_classes']);


        $this->set_data('style', $style);
    }
    public function get_css_classes()
    {
        return $this->data('css_classes').' '.$this->data('custom_classes');
    }
    // System Functions End


    public function html($string)
    {

        $this->set_data('html', $string);
        $this->html = $string;
    }

    // Option Functions Begin

    public function set_content($content)
    {
        $this->set_data('content', $content);
    }
    public function set_default($content)
    {
        $this->set_content($content);
    }

    public function set_global($bool){
        $this->global = $bool;
    }
    public function is_global(){
        return $this->global;
    }
    public function is_editable()
    {
        return $this->option("editable");
    }
    public function set_editable($bool)
    {
        $this->option("editable", $bool);
    }
    // Option Functions End

    public function remove_children()
    {
        $this->blocks = array();
    }
    public function remove_child($name)
    {
        foreach($this->blocks as $key => $child)
        {
            if($child->name == $name)
                unset($this->blocks[$key]);
        }
    }
    public function add_block($block)
    {
        //$this->blocks[count($this->blocks)] = &$block;
        array_push($this->blocks, $block);
        //print_r($this->blocks);
    }
    public function add_block_first($block)
    {
        //$this->blocks[count($this->blocks)] = &$block;
        array_unshift ( $this->blocks , $block );
        //print_r($this->blocks);
    }
    public function get_id()
    {
        return $this->id;
    }
    public function get_name()
    {
        return $this->name;
    }
    public function initialize($db_result)
    {
        //print_r($db_result);
        //echo debug_print_backtrace();
        $this->id   = $db_result->id;
        $this->data = json_decode($db_result->data, true);
        $this->global = $db_result->global == 'yes';
        $this->type = $db_result->type;
        $this->html = $this->data('html');
        $this->blocks = array();
        foreach($db_result->children as $child_name)
        {
            $child = new Block($child_name);
            $child->load();
            $this->add_block($child);
        }
    }

    public function save()
    {
        $this->db->trans_start();
        $children = array();

        foreach($this->blocks as $child)
        {
            array_push($children, $child->name);
        }
        if($this->is_new_block){
            $data['name'] = $this->name;
            $data['global'] = $this->global ? 'yes' : 'no';
            $data['type']   = $this->type;
            $data['data']   = json_encode($this->data, JSON_HEX_QUOT | JSON_HEX_TAG);
            PC::SavingData($data['data']);
            $data['children'] = $children;
            $this->layout_system->blocks->create($data);
            $this->is_new_block = false;
        }else{
            PC::SavingData(json_encode($this->data, JSON_HEX_QUOT | JSON_HEX_TAG));
            $this->layout_system->blocks->save($this->name, json_encode($this->data, JSON_HEX_QUOT | JSON_HEX_TAG), $children);
        }
        $this->db->trans_complete();
    }
    function admin_textarea($var, $title, $value = "")
    {

        echo"
            <div class=\"control-group\">
                <label class=\"control-label\" for=\"required\" style='width: 80px'><b>$title</b></label>
                <div class=\"controls controls-row\" style='margin-left: 85px'>
                    <textarea style=\" height:250px\" name=\"$var\" class=\"span11\" ng-model='$var'>$value</textarea>
                </div>
            </div><!-- End .control-group  -->
            ";
    }
    function admin_color_picker($var, $text)
    {
        $value = "#000000";
        $style = $this->data("style");
        if($style && isset($style[$var]) && $style[$var] != null)
            $value = $style[$var];
        echo "
            <div class=\"control-group\">
                <label class=\"control-label\" for=\"colorpicker\" style='width: 80px'>$text</label>
                <div class=\"controls controls-row\" style='margin-left: 85px'>
                    <input type=\"color\" class=\"color-picker\" name=\"$var\" value=\"$value\" />
                </div>
            </div>
            ";
    }

    function admin_input($var, $type, $title, $value = "", $placeholder = "")
    {
        $style = $this->data("style");


        if($style && isset($style[$var]) && $style[$var] != null)
            $value = $style[$var];

        if($type == "checkbox"){
            if(isset($style[$var]))
                $checked = "checked";
            else
                $checked = "";
            $width = "25px";
        }else{
            $checked = "";
            $width = "100%";
        }


        echo'
            <div class="form-group">
                <label for="exampleInputEmail1">'.$title.'</label>
                <input type="'.$type.'" name="'.$var.'" class="form-control" '.$checked.' value="'.$value.'" ng-model="'.$var.'" placeholder="'.$placeholder.'">
            </div>';

        /*echo"
        <div class=\"control-group\">
            <label class=\"control-label\" for=\"required\" style='width: 80px; '><b>$title</b></label>
            <div class=\"controls controls-row\" style='margin-left: 85px;text-align:left'>
                <input type=\"$type\" name=\"$var\" class=\"span2\" style='width: $width' $checked value='$value' ng-model='$var' placeholder='$placeholder'>
            </div>
        </div><!-- End .control-group  -->
        ";*/
    }

    function admin_file($var, $title, $value = "")
    {
        $style = $this->data("style");
        if($style && isset($style[$var]) && $style[$var] != null)
            $value = $style[$var];
        echo"
            <div class=\"control-group\">
                <label class=\"control-label\" for=\"required\" style='width: 80px'><b>$title</b></label>
                <div class=\"controls controls-row\" style='margin-left: 85px'>
                    <input type=\"file\" name=\"$var\" class=\"span11\" rel=\"file_manager\" file_value='$value' ng-model='$var'>
                </div>
            </div><!-- End .control-group  -->
            ";
    }

    function admin_select($var, $options, $title)
    {
        $style = $this->data("style");
        if($style && isset($style[$var]) && $style[$var] != null)
            $value = $style[$var];
        echo"
            <div class=\"control-group\">
                <label class=\"control-label\" for=\"required\" style='width: 80px'><b>$title</b></label>
                <div class=\"controls controls-row\" style='margin-left: 85px'>
                    <select name=\"$var\" class=\"span12\" >
                    ";
        foreach($options as $val => $name)
        {
            if($value == $val)
                echo "<option selected value='$val'>$name</option>";
            else
                echo "<option value='$val'>$name</option>";
        }
        echo"
                    </select>
                </div>
            </div><!-- End .control-group  -->
            ";
    }
}

/*class Block{
  protected $db;
  protected $versions;
  protected $content;
  protected $id;
  protected $db_id;

  protected $style;
  protected $static_style;
  protected $version;
  protected $global;
  protected $is_new;
  protected $absolute = false;
  protected $BuilderEngine;
  protected $forced_global = false;
  protected $classes;
  protected $forced_classes;
  protected $area = 0;
  protected $type;
  protected $is_ok_with_expand = false;
  function Block($id, $classes = "", $style="")
  {
      $this->type = "block";
      global $active_show;
      $this->BuilderEngine = &$active_show->controller->BuilderEngine;
      $this->global = false;

      $this->classes = $classes;

      if(!$this->forced_global){
          $this->global = $this->BuilderEngine->get_blocks_global();
      }
      $this->id = $id;
      $this->style = $style;


      $ci =& get_instance();
      $ci->load->model('versions');

      $this->db =& $ci->db;
      $this->versions =& $ci->versions;
      $this->load($id);

  }
  public function is_ok_with_expand()
  {
      $this->is_ok_with_expand = true;
  }
  public function set_area($area)
  {
      $this->area = $area;
  }
  function get_db_id(){ return $this->db_id; }
  function is_new(){ return $this->is_new;}
  function set_position_absolute(){
      $this->absolute = true;
  }
  function set_global($bool = true)
  {
      $this->forced_global = true;
      $this->global = $bool;
  }
  function set_default($content)
  {
      if($this->is_new)
          $this->content = $content;

  }
  function initialize()
  {


      switch(is_int($this->id))
      {
          case true:
              $data['id'] = $this->id;
              break;

          case false:
              $data['name'] = $this->id;
              break;
      }

      $data['area'] = $this->area;
      $data['classes'] = $this->classes;
      $data['content'] = $this->content;
      $data['type'] = $this->type;
      $data['style'] = $this->style;
      $data['static_style'] = $this->static_style;
      $data['active'] = "true";

      if($this->global)
          $data['global'] = "true";
      else
          $data['global'] = "false";

      $this->db->insert("blocks", $data);
      $this->db_id    = $this->db->insert_id();

      $version = 0;

      if($this->global){
          $version = $this->versions->get_current_layout_version();
      }else{
          $version = $this->versions->get_current_page_version();
      }


      $this->versions->bind_block_to_page_version($this->id, $version);

  }
  function load($id)
  {
      $result = $this->versions->load_block($id);

      if(!$result){
          $this->is_new = true;
          return;

      }

      $this->is_new = false;
      $this->db_id    = $result->id;
      $this->content = $result->content;
      $this->version = $result->version;
      $this->global = $result->global == "true";
      $this->style = $result->style;
      $this->static_style = $result->static_style;
      $this->version = $result->version;
      $this->classes = $result->classes;
  }

  function show()
  {
      if($this->is_new){
          $this->initialize();
      }
      $expand = " expand='false' ";
      if($this->is_ok_with_expand)
          $expand = " expand='true' ";

      global $active_controller;
      if($active_controller->user->is_member_of("Administrators")){
          $attr = "contenteditable='false'";
      }else
          $attr = "";
      echo "<div $expand $attr class='block resizable movable ".$this->classes."' id='block-".$this->id."' blockid='".$this->db_id."' style='".$this->style.$this->static_style."'>";
      echo $this->content;
      echo "</div>";
  }
}

class Styler extends Block
{
  private $style_classes;
  private $css = array();
  function Styler($id, $classes, $auto_show = true)
  {
      $this->style_classes = $classes; // Do not play smart by moving this line after the parent constructor. You have been warned!
      parent::__construct($id,"");

      $this->global = false;
      if($this->is_new){
          $this->initialize("");
          if($auto_show)
           $this->show();
      }
  }
  function css($key, $value = null)
  {
      if($value == null)
      {
          if(is_array($key))
              $this->css = $key;
          else
              return $this->css[$key] ;
      }else{
          $this->css[$key] = $value;
      }

  }
  function compile_css()
  {
      $string = "";

      foreach ($this->css as $key => $value)
      {
          $string .= $key.": ".$value."; ";

      }
      return $string;
  }
  function show($return_output = false)
  {

      $expand = " expand='false' ";
      if($this->is_ok_with_expand)
          $expand = " expand='true' ";
      if($return_output)
          return " $expand class='{$this->style_classes} resizable movable' changeablebg=\"true\" id='block-".$this->id."' blockid='".$this->id."' style=' ".$this->compile_css().$this->style."' ";
      else
          echo " class='{$this->style_classes} resizable movable' changeablebg=\"true\" id='block-".$this->id."' blockid='".$this->id."' style=' ".$this->compile_css()." ".$this->style."' ";
  }
}

class IconSelector extends Block
{
  private $icon_style;
  private $forced_class = "";
  function IconSelector($id, $icon_class, $style = "")
  {
      $this->icon_style = $style;
      $this->static_style = $style;
      $this->classes = $icon_class;
       // Do not play smart by moving this line after the parent constructor. You have been warned!
      parent::__construct($id,$icon_class, $style);
      $this->type = "icon";


  }
  function force_class($class)
  {
      $this->forced_class .= $class." ";
  }
  function show()
  {
      if($this->is_new){
          $this->initialize("");

      }
      echo "<i class='{$this->classes} movable {$this->forced_class}' id='block-".$this->id."' blockid='".$this->db_id."' changeableicon=\"true\" style='".$this->style." ".$this->icon_style."'></i>";
  }
}

class Background_Selector extends Block
{
  private $bg_style;
  private $forced_class = "";
  function Background_Selector($id, $bg_class, $style = "")
  {
      $this->bg_style = $style;
      $this->static_style = $style;
      $this->classes = $bg_class;
       // Do not play smart by moving this line after the parent constructor. You have been warned!
      parent::__construct($id,$bg_class, $style);
      $this->type = "background_selector";


  }
  function force_class($class)
  {
      $this->forced_class .= $class." ";
  }
  function show()
  {
      if($this->is_new){
          $this->initialize("");

      }
      echo " class='{$this->classes} {$this->forced_class}' id='bg-selection-".$this->id."' blockid='".$this->db_id."' changeablebg=\"true\" style='".$this->style." ".$this->bg_style."'";
  }
}*/
?>