<?php

	global $scroll_rate;

        function initialize_simple_parallax_js()
        {
            global $scroll_rate;

            echo '
					<script type="text/javascript">
						$(document).ready(function() {
							$(window).scroll(function(){
								$(\'*[class^="prlx"]\').each(function(r){
									var pos = $(this).offset().top;
									var scrolled = $(window).scrollTop();
									$(\'*[class^="prlx"]\').css(\'top\', -(scrolled * '.$scroll_rate.') + \'px\');			
								});
							});
						});
					</script>
            ';
        }
		add_action('be_foot','initialize_simple_parallax_js');

    class simple_parallax_scroller_block_handler extends block_handler
	{

        function info()
        {
            $info['category_name'] = "Core";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Simple Parallax Scroller";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
		
		public function generate_admin()
		{
			$scroll_rate = $this->block->data('scroll_rate');
			$title = $this->block->data('title');
            $image = base_url().'blocks/simple_parallax_scroller/images/image2.png';
			$default_image = $this->block->data('default_image');
		   
			$text1 = $this->block->data('text1');
			$text2 = $this->block->data('text2');
			$text3 = $this->block->data('text3');
			
			$button_url = $this->block->data('button_url');
			$parallax_content = $this->block->data('parallax_content');
			
			?>
		
           <style>
            #settings-content .form-group
            {
                margin-left:0px !important;
                width:90% !important;
            }
            </style>
                <ul id="myTab" class="nav nav-tabs" style="margin-left:-15px">
                    <li class="active"><a href="#general" data-toggle="tab">General</a></li>
                    <li><a href="#settings" data-toggle="tab">Settings</a></li>
					<li><a href="#title" data-toggle="tab">Title</a></li>
					<li><a href="#text" data-toggle="tab">Text</a></li>
					<li><a href="#link" data-toggle="tab">Button Link</a></li>
                    <li><a href="#image" data-toggle="tab">Image</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="general">
                        <?php $this->admin_select('parallax_type',array("simple" => "Simple Parallax Slider"),'Parallax Type');?>
						<?php $this->admin_select('parallax_content',array("default" => "Default Content","custom" => "Custom Content"),'Parallax Content',$parallax_content);?>
                    </div>
                    <div class="tab-pane" id="settings">
                        <?php
							$this->admin_select('scroll_rate',array('1.0' => 'Default', '0.2' => '0.2', '0.4' => '0.4', '0.6' => '0.6', '0.8' =>'0.8', '1' => '1'),'Scroll depth rate: ');
                        ?>
                    </div>
                    <div class="tab-pane" id="title">
                        <?php
							$this->admin_textarea('title',"Title:",'Simple <strong>Parallax</strong>');
                        ?>
						<pre>You can use html markup here.(see above)</pre>
                    </div>
                    <div class="tab-pane" id="text">
                        <?php
							$this->admin_textarea('text1',"Text 1", 'This is text 1.Simple Parallax is a multipurpose parallax template for business or portfolio website. It is fully responsive design ready for PC, Tablet and Mobile.');
							$this->admin_textarea('text2',"Text 2", 'This is text 2.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas metus nulla, commodo a sodales sed, dignissim pretium nunc. Nam et lacus neque.');
							$this->admin_textarea('text3',"Text 3", 'This is text 3.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas metus nulla, commodo a sodales sed, dignissim pretium nunc.');
                        ?>
                    </div>
                    <div class="tab-pane" id="link">
                        <?php
							$this->admin_input('button_url',"Button Url:",'http://builderengine.com');
                        ?>
                    </div>
                    <div class="tab-pane" id="image">
                        <?php
							$this->admin_select('default_image', array("custom" => "Use selected image","default" => "Use default image","no" => "No Image"),'Default Image: ',$default_image);
                            $this->admin_file('image','Add Image: ', $image, 'spc'.$this->block->get_id(), true);
                        ?>
						<script>
							$("#spc<?=$this->block->get_id()?>").click(function(e){
							   e.preventDefault();
							});						
						</script>
					</div>		
		<?php
		}
		
        public function generate_style()
        {
			$path = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/index.php'));
			include $path.'/builderengine/public/animations/animations.php';
			
			$title_font_color = $this->block->data('title_font_color');
			$title_font_size = $this->block->data('title_font_size');
			$title_font_weight = $this->block->data('title_font_weight');
			$title_background_color = $this->block->data('title_background_color');			
 		    $title_animation_type = $this->block->data('title_animation_type');	  
		    $title_animation_duration = $this->block->data('title_animation_duration');
		    $title_animation_event = $this->block->data('title_animation_event');
		    $title_animation_delay = $this->block->data('title_animation_delay');
			
            $text1_font_color = $this->block->data('text1_font_color');
			$text1_font_weight = $this->block->data('text1_font_weight');
            $text1_font_size = $this->block->data('text1_font_size');
			$text1_background_color = $this->block->data('text1_background_color');
 		    $text1_animation_type = $this->block->data('text1_animation_type');	  
		    $text1_animation_duration = $this->block->data('text1_animation_duration');
		    $text1_animation_event = $this->block->data('text1_animation_event');
		    $text1_animation_delay = $this->block->data('text1_animation_delay');
			
            $text2_font_color = $this->block->data('text2_font_color');
			$text2_font_weight = $this->block->data('text2_font_weight');
            $text2_font_size = $this->block->data('text2_font_size');
			$text2_background_color = $this->block->data('text2_background_color');
 		    $text2_animation_type = $this->block->data('text2_animation_type');	  
		    $text2_animation_duration = $this->block->data('text2_animation_duration');
		    $text2_animation_event = $this->block->data('text2_animation_event');
		    $text2_animation_delay = $this->block->data('text2_animation_delay');
			
            $text3_font_color = $this->block->data('text3_font_color');
			$text3_font_weight = $this->block->data('text3_font_weight');
            $text3_font_size = $this->block->data('text3_font_size');
			$text3_background_color = $this->block->data('text3_background_color');
 		    $text3_animation_type = $this->block->data('text3_animation_type');	  
		    $text3_animation_duration = $this->block->data('text3_animation_duration');
		    $text3_animation_event = $this->block->data('text3_animation_event');
		    $text3_animation_delay = $this->block->data('text3_animation_delay');
			
            $button_font_color = $this->block->data('button_font_color');
			$button_font_weight = $this->block->data('button_font_weight');
            $button_font_size = $this->block->data('button_font_size');
			$button_background_color = $this->block->data('button_background_color');
 		    $button_animation_type = $this->block->data('button_animation_type');	  
		    $button_animation_duration = $this->block->data('button_animation_duration');
		    $button_animation_event = $this->block->data('button_animation_event');
		    $button_animation_delay = $this->block->data('button_animation_delay');
			
 		    $image_animation_type = $this->block->data('image_animation_type');	  
		    $image_animation_duration = $this->block->data('image_animation_duration');
		    $image_animation_event = $this->block->data('image_animation_event');
		    $image_animation_delay = $this->block->data('image_animation_delay');
			
			$background_image = $this->block->data('background_image');
			$background_default = $this->block->data('background_default');
			
            ?>
            <div role="tabpanel">
			
                <ul class="nav nav-tabs" role="tablist" style="margin-left: -20px;">
					<li role="presentation" class="active"><a href="#title" aria-controls="title" role="tab" data-toggle="tab">Title</a></li>
                    <li role="presentation"><a href="#text1" aria-controls="text1" role="tab" data-toggle="tab">Text 1</a></li>
					<li role="presentation"><a href="#text2" aria-controls="text2" role="tab" data-toggle="tab">Text 2</a></li>
					<li role="presentation"><a href="#text3" aria-controls="text3" role="tab" data-toggle="tab">Text 3</a></li>
					<li role="presentation"><a href="#button" aria-controls="button" role="tab" data-toggle="tab">Button</a></li>
					<li role="presentation"><a href="#imgs" aria-controls="imgs" role="tab" data-toggle="tab">Image</a></li>
                    <li role="presentation"><a href="#background" aria-controls="background" role="tab" data-toggle="tab">Background Image</a></li>
                    <li role="presentation"><a href="#customcss" aria-controls="customcss" role="tab" data-toggle="tab">Custom CSS</a></li>
                </ul>
				
                <div class="tab-content">
                     <div role="tabpanel" class="tab-pane fade in active" id="title">
                        <?php
                        $this->admin_input('title_font_color','text', 'Font color: ', $title_font_color);
                        $this->admin_input('title_background_color','text', 'Background color: ', $title_background_color);
                        $this->admin_input('title_font_weight','text', 'Font weight: ', $title_font_weight);
                        $this->admin_input('title_font_size','text', 'Font size: ', $title_font_size);
					    $this->admin_select('title_animation_type', $types,'Animation type: ',$title_animation_type);
					    $this->admin_select('title_animation_duration', $durations,'Animation duration: ',$title_animation_duration);
					    $this->admin_select('title_animation_event', $events,'Animation Start: ',$title_animation_event);
					    $this->admin_select('title_animation_delay', $delays,'Animation Delay: ',$title_animation_delay);	
                        ?>
                    </div>
                     <div role="tabpanel" class="tab-pane fade" id="text1">
                        <?php
                        $this->admin_input('text1_font_color','text', 'Font color: ', $text1_font_color);
                        $this->admin_input('text1_background_color','text', 'Background color: ', $text1_background_color);
                        $this->admin_input('text1_font_weight','text', 'Font weight: ', $text1_font_weight);
                        $this->admin_input('text1_font_size','text', 'Font size: ', $text1_font_size);
					    $this->admin_select('text1_animation_type', $types,'Animation type: ',$text1_animation_type);
					    $this->admin_select('text1_animation_duration', $durations,'Animation duration: ',$text1_animation_duration);
					    $this->admin_select('text1_animation_event', $events,'Animation Start: ',$text1_animation_event);	
					    $this->admin_select('text1_animation_delay', $delays,'Animation Delay: ',$text1_animation_delay);
                        ?>
                    </div>
                     <div role="tabpanel" class="tab-pane fade" id="text2">
                        <?php
                        $this->admin_input('text2_font_color','text', 'Font color: ', $text2_font_color);
                        $this->admin_input('text2_background_color','text', 'Background color: ', $text2_background_color);
                        $this->admin_input('text2_font_weight','text', 'Font weight: ', $text2_font_weight);
                        $this->admin_input('text2_font_size','text', 'Font size: ', $text2_font_size);
					    $this->admin_select('text2_animation_type', $types,'Animation type: ',$text2_animation_type);
					    $this->admin_select('text2_animation_duration', $durations,'Animation duration: ',$text2_animation_duration);
					    $this->admin_select('text2_animation_event', $events,'Animation Start: ',$text2_animation_event);	
					    $this->admin_select('text2_animation_delay', $delays,'Animation Delay: ',$text2_animation_delay);
                        ?>
                    </div>
                     <div role="tabpanel" class="tab-pane fade" id="text3">
                        <?php
                        $this->admin_input('text3_font_color','text', 'Font color: ', $text3_font_color);
                        $this->admin_input('text3_background_color','text', 'Background color: ', $text3_background_color);
                        $this->admin_input('text3_font_weight','text', 'Font weight: ', $text3_font_weight);
                        $this->admin_input('text3_font_size','text', 'Font size: ', $text3_font_size);
					    $this->admin_select('text3_animation_type', $types,'Animation type: ',$text3_animation_type);
					    $this->admin_select('text3_animation_duration', $durations,'Animation duration: ',$text3_animation_duration);
					    $this->admin_select('text3_animation_event', $events,'Animation Start: ',$text3_animation_event);	
					    $this->admin_select('text3_animation_delay', $delays,'Animation Delay: ',$text3_animation_delay);
                        ?>
                    </div>
                     <div role="tabpanel" class="tab-pane fade" id="button">
                        <?php
                        $this->admin_input('button_font_color','text', 'Font color: ', $button_font_color);
                        $this->admin_input('button_background_color','text', 'Background color: ', $button_background_color);
                        $this->admin_input('button_font_weight','text', 'Font weight: ', $button_font_weight);
                        $this->admin_input('button_font_size','text', 'Font size: ', $button_font_size);
					    $this->admin_select('button_animation_type', $types,'Animation type: ',$button_animation_type);
					    $this->admin_select('button_animation_duration', $durations,'Animation duration: ',$button_animation_duration);
					    $this->admin_select('button_animation_event', $events,'Animation Start: ',$button_animation_event);	
					    $this->admin_select('button_animation_delay', $delays,'Animation Delay: ',$button_animation_delay);
                        ?>
                    </div>
					<div role="tabpanel" class="tab-pane fade" id="imgs">
						<?php
					    $this->admin_select('image_animation_type', $types,'Animation type: ',$image_animation_type);
					    $this->admin_select('image_animation_duration', $durations,'Animation duration: ',$image_animation_duration);
					    $this->admin_select('image_animation_event', $events,'Animation Start: ',$image_animation_event);	
					    $this->admin_select('image_animation_delay', $delays,'Animation Delay: ',$image_animation_delay);
						?>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="background">
						<?php
						$this->admin_select('background_default', array("custom" => "Use selected background image","default" => "Use default background image"),'Default Background: ');
						?>
						<span style="color:#fff;margin-bottom:3px;">Best fit:(width and height should be min.1600x400 pixels)</span><br/>
						<?php
						$this->admin_file('background_image','Add Background image', $background_image, 'spc1'.$this->block->get_id(), true);
						?>
						<script>
							$("#spc1<?=$this->block->get_id()?>").click(function(e){
							   e.preventDefault();
							});						
						</script>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="customcss">
                        <?php
                        $custom_css = $this->block->data('custom_css');
                        $custom_classes = $this->block->data('custom_classes');
                        $this->admin_textarea('custom_css','Custom CSS: ', $custom_css, 4);
                        $this->admin_textarea('custom_classes','Custom Classes: ', $custom_classes, 2);
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
		
		public function generate_content()
		{	
			global $scroll_rate;
			$current_scroll_rate = $this->block->data('scroll_rate');
			if(empty($current_scroll_rate))
			    $scroll_rate = 1;
			else
			    $scroll_rate = $this->block->data('scroll_rate');
			$this->block->force_data_modification();
			$this->block->set_data('scroll_rate', $scroll_rate, true);
			$this->block->save();

            switch ($this->block->data('parallax_type'))
            {
                case "simple":
                    return $this->output_content();
                    break;
                case "advanced":
                    return $this->output_content();
                    break;
                default:
                    return $this->output_content();
                    break;
            }
		}
		
		public function output_content()
		{
            global $active_controller;
            $CI = &get_instance();
            $CI->load->module('layout_system');

            $custom_css = $this->block->data('custom_css');
			$style_arr['text'] = ';'.$custom_css;
			$this->block->set_data("style", $style_arr);

			$scroll_rate = $this->block->data('scroll_rate');
			$title = $this->block->data('title');
            $image = $this->block->data('image');
			$default_image = $this->block->data('default_image');
			$parallax_content = $this->block->data('parallax_content');
			
			$text1 = $this->block->data('text1');
			$text2 = $this->block->data('text2');
			$text3 = $this->block->data('text3');	
	
			$button_url = $this->block->data('button_url');
	
			$title_font_color = $this->block->data('title_font_color');
			$title_font_size = $this->block->data('title_font_size');
			$title_font_weight = $this->block->data('title_font_weight');
			$title_background_color = $this->block->data('title_background_color');			
 		    $title_animation_type = $this->block->data('title_animation_type');	  
		    $title_animation_duration = $this->block->data('title_animation_duration');
		    $title_animation_event = $this->block->data('title_animation_event');
		    $title_animation_delay = $this->block->data('title_animation_delay');
			
            $text1_font_color = $this->block->data('text1_font_color');
			$text1_font_weight = $this->block->data('text1_font_weight');
            $text1_font_size = $this->block->data('text1_font_size');
			$text1_background_color = $this->block->data('text1_background_color');
 		    $text1_animation_type = $this->block->data('text1_animation_type');	  
		    $text1_animation_duration = $this->block->data('text1_animation_duration');
		    $text1_animation_event = $this->block->data('text1_animation_event');
		    $text1_animation_delay = $this->block->data('text1_animation_delay');
			
            $text2_font_color = $this->block->data('text2_font_color');
			$text2_font_weight = $this->block->data('text2_font_weight');
            $text2_font_size = $this->block->data('text2_font_size');
			$text2_background_color = $this->block->data('text2_background_color');
 		    $text2_animation_type = $this->block->data('text2_animation_type');	  
		    $text2_animation_duration = $this->block->data('text2_animation_duration');
		    $text2_animation_event = $this->block->data('text2_animation_event');
		    $text2_animation_delay = $this->block->data('text2_animation_delay');
			
            $text3_font_color = $this->block->data('text3_font_color');
			$text3_font_weight = $this->block->data('text3_font_weight');
            $text3_font_size = $this->block->data('text3_font_size');
			$text3_background_color = $this->block->data('text3_background_color');
 		    $text3_animation_type = $this->block->data('text3_animation_type');	  
		    $text3_animation_duration = $this->block->data('text3_animation_duration');
		    $text3_animation_event = $this->block->data('text3_animation_event');
		    $text3_animation_delay = $this->block->data('text3_animation_delay');
			
            $button_font_color = $this->block->data('button_font_color');
			$button_font_weight = $this->block->data('button_font_weight');
            $button_font_size = $this->block->data('button_font_size');
			$button_background_color = $this->block->data('button_background_color');
 		    $button_animation_type = $this->block->data('button_animation_type');	  
		    $button_animation_duration = $this->block->data('button_animation_duration');
		    $button_animation_event = $this->block->data('button_animation_event');
		    $button_animation_delay = $this->block->data('button_animation_delay');
			
 		    $image_animation_type = $this->block->data('image_animation_type');	  
		    $image_animation_duration = $this->block->data('image_animation_duration');
		    $image_animation_event = $this->block->data('image_animation_event');
		    $image_animation_delay = $this->block->data('image_animation_delay');
			
			$background_image = $this->block->data('background_image');
			$background_default = $this->block->data('background_default');
			
			$settings[0][0] = 'stext1'.$this->block->get_id();
			$settings[0][1] = $text1_animation_event;
			$settings[0][2] = $text1_animation_duration.' '.$text1_animation_delay.' '.$text1_animation_type;
			$settings[1][0] = 'stitle'.$this->block->get_id();
			$settings[1][1] = $title_animation_event;
			$settings[1][2] = $title_animation_duration.' '.$title_animation_delay.' '.$title_animation_type;
			$settings[2][0] = 'sbutton'.$this->block->get_id();
			$settings[2][1] = $button_animation_event;
			$settings[2][2] = $button_animation_duration.' '.$button_animation_delay.' '.$button_animation_type;
			$settings[3][0] = 'simage'.$this->block->get_id();
			$settings[3][1] = $image_animation_event;
			$settings[3][2] = $image_animation_duration.' '.$image_animation_delay.' '.$image_animation_type;
			$settings[4][0] = 'stext2'.$this->block->get_id();
			$settings[4][1] = $text2_animation_event;
			$settings[4][2] = $text2_animation_duration.' '.$text2_animation_delay.' '.$text2_animation_type;
			$settings[5][0] = 'stext3'.$this->block->get_id();
			$settings[5][1] = $text3_animation_event;
			$settings[5][2] = $text3_animation_duration.' '.$text3_animation_delay.' '.$text3_animation_type;

			add_action("be_foot", generate_animation_events($settings));
			
			if($parallax_content != 'custom'){
				$title = 'Simple <strong>Parallax</strong>';
				if($default_image != 'no')
					$image = base_url().'blocks/simple_parallax_scroller/images/image2.png';
				$text1 = 'This is text 1.Simple Parallax is a multipurpose parallax template for business or portfolio website. It is fully responsive design ready for PC, Tablet and Mobile.';
				$text2 = 'This is text 2.Simple Parallax is a multipurpose parallax template for business or portfolio website. It is fully responsive design ready for PC, Tablet and Mobile.';
				$text3 = 'This is text 3.Simple Parallax is a multipurpose parallax template for business or portfolio website. It is fully responsive design ready for PC, Tablet and Mobile.';
				$button_url = 'http://builderengine.com';
			}	
            $title_style = 
                'style="
                    color: '.$title_font_color.' !important;
					font-size: '.$title_font_size.' !important;
                    font-weight: '.$title_font_weight.' !important;
					background-color: '.$title_background_color.' !important;
                "';
            $text1_style = 
                'style="
                    color: '.$text1_font_color.' !important;
					font-size: '.$text1_font_size.' !important;
                    font-weight: '.$text1_font_weight.' !important;
					background-color: '.$text1_background_color.' !important;
					padding:10px;
                "';
            $text2_style = 
                'style="
                    color: '.$text2_font_color.' !important;
					font-size: '.$text2_font_size.' !important;
                    font-weight: '.$text2_font_weight.' !important;
					background-color: '.$text2_background_color.' !important;
					padding:10px;
                "';
            $text3_style = 
                'style="
                    color: '.$text3_font_color.' !important;
					font-size: '.$text3_font_size.' !important;
                    font-weight: '.$text3_font_weight.' !important;
					background-color: '.$text3_background_color.' !important;
					padding:10px;
                "';
            $button_style = 
                'style="
                    color: '.$button_font_color.' !important;
					font-size: '.$button_font_size.' !important;
                    font-weight: '.$button_font_weight.' !important;
					background-color: '.$button_background_color.' !important;
					padding:15px 25px;
					font-size:18px;
                "';
				
			if($parallax_content != 'custom')
			{
				$background_style = 
									'style="
						background: url('.base_url().'blocks/simple_parallax_scroller/images/parallax.jpg) repeat; !important;
						background-size:100% 100%;";
				"';
				$img = '<img id="simage'.$this->block->get_id().'" class="img-responsive pull-right" style="width:450px; height:350px; position: absolute;right: 50px;top: 50px;" src="'.base_url().'blocks/simple_parallax_scroller/images/image2.png"/>';
			}
			else
			{
				$background_style = 
					'style="
						background: url('.$background_image.') repeat; !important;
						background-size:100% 100%;";
				"';
				if($default_image == 'no')
					$img = '';
				else
					$img = '<img id="simage'.$this->block->get_id().'" class="img-responsive pull-right" style="width:450px; height:350px; position: absolute;right: 50px;top: 50px;" src="'.$image.'"/>';
			}

			$output ='
					<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet">
					<link type="text/css" rel="stylesheet" href="'.base_url('blocks/simple_parallax_scroller/css/style.css').'">				
				<section class="section-one" id="parallax-scroller-'.$this->block->get_id().'">
					<div class="prlx-1" '.$background_style.'></div>
					
						<h2 id="stitle'.$this->block->get_id().'" '.$title_style.'>'.$title.'</h2>
						
						<p id="stext1'.$this->block->get_id().'" class="text1" '.$text1_style.'>'.$text1.'</p>
						<p id="stext2'.$this->block->get_id().'" class="text2" '.$text2_style.'>'.$text2.'</p><br/><br/>
						<p id="stext3'.$this->block->get_id().'" class="text3" '.$text3_style.'>'.$text3.'</p>
						<a id="sbutton'.$this->block->get_id().'" class="btn btn-large btn-danger btn-main" '.$button_style.' href="'.$button_url.'" target="_blank" >Tell Me More</a>
						'.$img.'
				</section>
			';

            return $output.$CI->layout_system->load_new_block_scripts($this->block->get_id(), "parallax-scroller-".$this->block->get_id(), $CI->BuilderEngine->get_page_path(), '', $this->block->get_name(), 'with_settings');
		}
    }
?>