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

	class Block_handler {
		protected $block = array();
        protected $options = array();

		function info()
		{
			return array();
		}
        function save()
        {
            $this->block->set_data('admin_options', $this->options, true);
            $this->block->save();
        }
        function admin_option_toggle($option_name, $toggled)
        {
            $this->options[$option_name]['toggled'] = $toggled == 'true';
            $this->save();
            $function = "admin_option_toggle_".$option_name;
            $this->$function($toggled == true || $toggled == "true");

        }
        function admin_option_select($option_name, $option_choice)
        {
            $this->options[$option_name]['selected'] = $option_choice;
            $this->save();
            $function = "admin_option_select_".$option_name;
            $this->$function($option_choice);

        }
        function add_class_toggle_option($option_name, $display_text, $class_name, $default_toggled = false)
        {
            $option['type']         = 'class_toggle';
            $option['name']         = $option_name;
            $option['display_text'] = $display_text;
            $option['class_name']   = $class_name;
            $option['toggled']      = $default_toggled;
            $this->options[$option_name] = $option;
        }
        function add_select_option($option_name, $display_text, $options, $default_toggled = false)
        {
            $option['type']         = 'select';
            $option['name']         = $option_name;
            $option['display_text'] = $display_text;
            $option['options']   = $options;
            $option['selected']      = $default_toggled;
            $this->options[$option_name] = $option;
        }
        function register_admin_options()
        {

        }
        function output_admin_options()
        {
            $output = "";
            foreach($this->options as $option)
            {
                $function_name = "output_admin_option_".$option['type'];
                $output .= $this->$function_name($option);
            }
            return $output;
        }
        function output_admin_option_class_toggle($option)
        {
            $active_class = "";

            if($option['toggled'])
                $active_class = "active";

            $output = '<a class="btn btn-xs btn-white toggle-class '.$active_class.'" toggle-option="'.$option['name'].'" href="#" rel="navbar-inverse">'.$option['display_text'].'</a>';
            return $output;
        }
        function output_admin_option_select($option)
        {
        	$output = '<span class="btn-group btn-group-xs">
				<a style="font-size: 11px !important" class="btn btn-xs btn-white dropdown-toggle btn-white" data-toggle="dropdown" href="#">'.$option['display_text'].' <span class="caret"></span></a>
				<ul class="dropdown-menu block-select-options" data-option-name="'.$option['name'].'">';
							
			foreach($option['options'] as $opt_name => $opt)
			{
				$active = '';
				if($option['selected'] == $opt_name)
					$active = 'active';

				$output .= '<li class="'.$active.'"><a href="#" rel="" class="block-select-option" data-option-choice="'.$opt_name.'">'.$opt['display_name'].'</a></li>';
			}			
			$output .='			</ul>
			</span>';
        	return $output;
        }
		function admin_textarea($var, $title, $value = "")
		{
			if($this->block->data($var) != "")
				$value = $this->block->data($var);

	        echo'
			<link href="'.get_theme_path().'css/bootstrap.min.css" rel="stylesheet">
            <div class="form-group">
                <label>'.$title.'</label>
                <textarea name="'.$var.'" class="form-control" ng-model="'.$var.'">'.$value.'</textarea>
            </div>';
		}

		function admin_input($var, $type, $title, $value = "", $block_id = null)
		{

			if($this->block->data($var) != "")
				$value = $this->block->data($var);
			if($type == 'checkbox')
				$id = 'id="checkbox-'.$block_id.'"';
			else
				$id = '';

			echo'
			<link href="'.get_theme_path().'css/bootstrap.min.css" rel="stylesheet">
            <div class="form-group">
                <label>'.$title.'</label>
                <input '.$id.' type="'.$type.'" name="'.$var.'" class="form-control" value="'.$value.'" ng-model="'.$var.'" placeholder="'.$title.'">
            </div>';

			/*echo"
			<div class=\"control-group\">
	            <label class=\"control-label\" for=\"required\" style='width: 80px'><b>$title</b></label>
	            <div class=\"controls controls-row\" style='margin-left: 85px'>
	                <input type=\"$type\" name=\"$var\" class=\"span11\" value='$value' ng-model='$var'>
	            </div>
	        </div><!-- End .control-group  -->
	        ";*/
		}

		function admin_file($var, $title, $value = "", $id = "",$button = false)
		{
			if($value == "")
				$value = $this->block->data($var);
			if($button){
				$button_style = '
					<style>		
						.file_preview {
							max-height: 100px;
							max-width:100px;
							margin-top: 2px;
							margin-left:-175px;
						}
						label.file_label{
							width:100%;
							height:100%;
						}
						#'.$id.'{
							display:none;
						}
					</style>';
				echo'
					<span class="btn btn-success fileinput-button" style="height:35px;width:190px;margin-left:-15px;margin-right:15px;">
						<link href="'.get_theme_path().'css/bootstrap.min.css" rel="stylesheet">
						'.$button_style.'
						<div class="form-group">
							<label for="'.$id.'" class="file_label">'.$title.'</label>
							<input type="file" id="'.$id.'" name="'.$var.'" class="form-control" rel="file_manager" file_value="'.$value.'" ng-model="'.$var.'">
						</div>
					</span>
				';					
			}else{
				$button_style = '';
				echo'
					<link href="'.get_theme_path().'css/bootstrap.min.css" rel="stylesheet">
					<div class="form-group">
						<label for="'.$id.'" class="file_label">'.$title.'</label>
						<input type="file" id="'.$id.'" name="'.$var.'" class="form-control" rel="file_manager" file_value="'.$value.'" ng-model="'.$var.'">
					</div>
				';
			}
		}

		function admin_select($var, $options, $title, $value = "")
		{
			
			echo'
			<link href="'.get_theme_path().'css/bootstrap.min.css" rel="stylesheet">
			<div class="form-group">
				<label>'.$title.'</label>
				<select name='.$var.' class="form-control">';
				foreach($options as $val => $name)
                {
                	if($value == $val)
                		echo '<option selected value='.$val.'>'.$name.'</option>';
                	else
                		echo '<option value='.$val.'>'.$name.'</option>';
                }
	            echo'
				</select>
			</div>
			';

			/*echo"
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
	        ";*/
		}
        function load_options()
        {
            $this->register_admin_options();
            $options = $this->block->data('admin_options');
            if($options != null)
                $this->options = $options;

            if(empty($this->options))
            {
                $this->options = array();
                PC::admin_options("Initialize ".$this->block->name);
            }
        }
		function set_block($block)
		{
			$this->block = &$block;
            $this->load_options();
		}
        protected function createCaptcha($block_id)
        {
            $CI = & get_instance();
            $CI->load->library('session');
            $CI->load->helper(array('form', 'url','captcha'));

            $original_string = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
            $original_string = implode("", $original_string);
            $captcha = substr(str_shuffle($original_string), 0, 6);

             // Field validation failed.  User redirected to login page
            $vals = array(
                'word' => $captcha,
                'img_path' => './files/captcha/',
                'img_url' => base_url('files/captcha').'/',
                'font_path' => BASEPATH.'fonts/texb.ttf',
                'img_width' => 150,
                'img_height' => 45,
                'expiration' => 7200
            );

            $cap = create_captcha($vals);

            if(isset($this->session->userdata['image']))
                if(file_exists(BASEPATH."../files/captcha/".$CI->session->userdata['image']))
                    unlink(BASEPATH."../files/captcha/".$CI->session->userdata['image']);

            $CI->session->set_userdata(array(
                'captcha'.$block_id => $cap['word'],
                'image' => $cap['time'].'.jpg'
            ));

            return $cap['image'];
        }

	}

?>