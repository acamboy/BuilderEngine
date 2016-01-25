<?php 	class contact_form_block_handler extends  block_handler{
		function info()
		{
			$info['category_name'] = "Core";
			$info['category_icon'] = "dsf";

			$info['block_name'] = "Contact Form";
			$info['block_icon'] = "fa-envelope-o";
			
			return $info;
		}
		public function generate_admin()
		{
            $field1_name = $this->block->data('field1_name');
            $field1_active = $this->block->data('field1_active');
            $field1_required = $this->block->data('field1_required');

            $field2_name = $this->block->data('field2_name');
            $field2_active = $this->block->data('field2_active');
            $field2_required = $this->block->data('field2_required');

            $field3_name = $this->block->data('field3_name');
            $field3_active = $this->block->data('field3_active');
            $field3_required = $this->block->data('field3_required');

            $field4_name = $this->block->data('field4_name');
            $field4_active = $this->block->data('field4_active');
            $field4_required = $this->block->data('field4_required');

            $email_destination = $this->block->data('email_destination');
            $email_title = $this->block->data('email_title');
            $email_active = $this->block->data('email_active');

            $captcha_active = $this->block->data('captcha_active');

            ?>
            <link href="<?=get_theme_path()?>css/bootstrap.min.css" rel="stylesheet">
            <div role="tabpanel">

                <ul class="nav nav-tabs" role="tablist" style="margin-left: -20px;">
                    <li role="presentation" class="active"><a href="#field_1" aria-controls="field_1" role="tab" data-toggle="tab">Field 1</a></li>
                    <li role="presentation"><a href="#field_2" aria-controls="field_2" role="tab" data-toggle="tab">Field 2</a></li>
                    <li role="presentation"><a href="#field_3" aria-controls="field_3" role="tab" data-toggle="tab">Field 3</a></li>
                    <li role="presentation"><a href="#field_4" aria-controls="field_4" role="tab" data-toggle="tab">Field 4</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
                </ul>

                <div class="tab-content">
                    <?php
                    $bool_options = array(
                        "yes" => "Yes",
                        "no" => "No"
                        );
                    ?>
                    <div role="tabpanel" class="tab-pane fade in active" id="field_1">
                        <?php
                        $this->admin_input('field1_name','text', 'Name: ', $field1_name);
                        $this->admin_select('field1_active', $bool_options, 'Active: ', $field1_active);
                        $this->admin_select('field1_required', $bool_options, 'Required: ', $field1_required);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="field_2">
                        <?php
                        $this->admin_input('field2_name','text', 'Name: ', $field2_name);
                        $this->admin_select('field2_active', $bool_options, 'Active: ', $field2_active);
                        $this->admin_select('field2_required', $bool_options, 'Required: ', $field2_required);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="field_3">
                        <?php
                        $this->admin_input('field3_name','text', 'Name: ', $field3_name);
                        $this->admin_select('field3_active', $bool_options, 'Active: ', $field3_active);
                        $this->admin_select('field3_required', $bool_options, 'Required: ', $field3_required);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="field_4">
                        <?php
                        $this->admin_input('field4_name','text', 'Name: ', $field4_name);
                        $this->admin_select('field4_active', $bool_options, 'Active: ', $field4_active);
                        $this->admin_select('field4_required', $bool_options, 'Required: ', $field4_required);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="settings">
                        <?php
                        $this->admin_input('email_destination','text', 'Destination email: ', $email_destination);
                        $this->admin_input('email_title','text', 'Email title: ', $email_title);
                        $this->admin_select('email_active', $bool_options, 'Contact form active: ', $email_active);
                        $this->admin_select('captcha_active', $bool_options, 'Captcha: ', $captcha_active);
                        ?>
                    </div>
                </div>

            </div>
            <?php
        }
        public function generate_style()
        {
			$path = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/index.php'));
			include $path.'/builderengine/public/animations/animations.php';
            $form_text_font_color = $this->block->data('form_text_font_color');
            $form_text_font_weight = $this->block->data('form_text_font_weight');
            $form_text_font_size = $this->block->data('form_text_font_size');
            $form_background_color = $this->block->data('form_background_color');
			$form_animation_type = $this->block->data('form_animation_type');	  
		    $form_animation_duration = $this->block->data('form_animation_duration');
		    $form_animation_event = $this->block->data('form_animation_event');
		    $form_animation_delay = $this->block->data('form_animation_delay');
			
            $this->admin_input('form_text_font_color','text', 'Form text font color: ', $form_text_font_color);
            $this->admin_input('form_text_font_weight','text', 'Form text font weight: ', $form_text_font_weight);
            $this->admin_input('form_text_font_size','text', 'Form text font size: ', $form_text_font_size);
            $this->admin_input('form_background_color','text', 'Form text background color: ', $form_background_color);
			$this->admin_select('form_animation_type', $types,'Animation type: ',$form_animation_type);
			$this->admin_select('form_animation_duration', $durations,'Animation duration: ',$form_animation_duration);
			$this->admin_select('form_animation_event', $events,'Animation Start: ',$form_animation_event);
			$this->admin_select('form_animation_delay', $delays,'Animation Delay: ',$form_animation_delay);
        }
		public function generate_content()
		{
            $field1_name = $this->block->data('field1_name');
            $field1_active = $this->block->data('field1_active');
            $field1_required = $this->block->data('field1_required');

            $field2_name = $this->block->data('field2_name');
            $field2_active = $this->block->data('field2_active');
            $field2_required = $this->block->data('field2_required');

            $field3_name = $this->block->data('field3_name');
            $field3_active = $this->block->data('field3_active');
            $field3_required = $this->block->data('field3_required');

            $field4_name = $this->block->data('field4_name');
            $field4_active = $this->block->data('field4_active');
            $field4_required = $this->block->data('field4_required');

            $email_destination = $this->block->data('email_destination');
            $email_title = $this->block->data('email_title');
            $email_active = $this->block->data('email_active');

            $captcha_active = $this->block->data('captcha_active');

			$form_animation_type = $this->block->data('form_animation_type');	  
		    $form_animation_duration = $this->block->data('form_animation_duration');
		    $form_animation_event = $this->block->data('form_animation_event');
		    $form_animation_delay = $this->block->data('form_animation_delay');
			$settings[0][0] = 'form'.$this->block->get_id();
			$settings[0][1] = $form_animation_event;
			$settings[0][2] = $form_animation_duration.' '.$form_animation_delay.' '.$form_animation_type;
			add_action("be_foot", generate_animation_events($settings));
			
            if($field1_name == '')
                $field1_name = 'Name';
            if($field2_name == '')
                $field2_name = 'Email';
            if($field3_name == '')
                $field3_name = 'Phone';
            if($field4_name == '')
                $field4_name = 'Message';
            if($email_title == '')
                $email_title = 'Message submitted in '.base_url().' contact form';

            // style
            $form_text_font_color = $this->block->data('form_text_font_color');
            $form_text_font_weight = $this->block->data('form_text_font_weight');
            $form_text_font_size = $this->block->data('form_text_font_size');
            $form_background_color = $this->block->data('form_background_color');
			$error = '';

            if(isset($_POST['contactform'.$this->block->get_id()]))
            {
				unset($_POST['contactform'.$this->block->get_id()]);
                if($email_active != 'no')
                {
                    $to = $email_destination;
                    $title = $email_title;
                    $message = "
                    Contact form message received:";
                    $count = 1;
					if($captcha_active == 'yes' && isset($_POST['captcha'])){
						if($_POST['captcha'] == $_SESSION['captcha'.$this->block->get_id()]){
							unset($_SESSION['captcha'.$this->block->get_id()]);
							unset($_POST['captcha']);
							foreach ($_POST as $field_name => $field_value)
							{
								if($field_value == '')
									$field_value = '[empty]';
								if($count == 1)
									$message .= "\n\n".str_replace('_', ' ', ucwords($field_name)). ": ".$field_value;
								else
									$message .= "\n".str_replace('_', ' ', ucwords($field_name)). ": ".$field_value;

								$count++;
							}
							$message .= "\n\n".base_url();

							mail($to, $title, $message);
						}else{
							$error = 'Wrong captcha ! ';
						}
					}else{
						foreach ($_POST as $field_name => $field_value)
						{
							if($field_value == '')
								$field_value = '[empty]';
							if($count == 1)
								$message .= "\n\n".str_replace('_', ' ', ucwords($field_name)). ": ".$field_value;
							else
								$message .= "\n".str_replace('_', ' ', ucwords($field_name)). ": ".$field_value;

							$count++;
						}
						$message .= "\n\n".base_url();

						mail($to, $title, $message);
					}
                }
            }
            $background_style = 
                'style="
                    background-color: '.$form_background_color.' !important;
                "';
            $label_style = 
                'style="
                    color: '.$form_text_font_color.' !important;
                    font-weight: '.$form_text_font_weight.' !important;
                    font-size: '.$form_text_font_size.' !important;
					padding-right:15px; !important;
                "';

			$output = '
                <link href="'.base_url('blocks/contact_form/style.css').'" rel="stylesheet">
				<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
				<div class="row">
				<div id="form'.$this->block->get_id().'" '.$background_style.' class="col-md-12 form-col" data-animation="true" data-animation-type="fadeInRight">
                    <form class="form-horizontal" style="padding-right:20px !important;padding-left:20px !important;" method="post">';
                    if($field1_active != 'no')
                    {
                        $output .= '
                        <div class="form-group">
                            <label '.$label_style.' class="control-label col-md-3">'.$field1_name;
                            if($field1_required == 'yes')
                                $output .= ' <span class="text-theme">*</span>';
                            $output .= '
                            </label>
                            <div class="col-md-9">
                                <input type="text" name="'.strtolower(str_replace(' ', '_', $field1_name)).'" class="form-control"';
                            if($field1_required == 'yes')
                                $output .= ' required';
                            $output .= '/>
                            </div>
                        </div>';
                    }
                    if($field2_active != 'no')
                    {
                        $output .= '
                        <div class="form-group">
                            <label '.$label_style.' class="control-label col-md-3">'.$field2_name;
                            if($field2_required == 'yes')
                                $output .= ' <span class="text-theme">*</span>';
                            $output .= '
                            </label>
                            <div class="col-md-9">
                                <input type="text" name="'.strtolower(str_replace(' ', '_', $field2_name)).'" class="form-control"';
                            if($field2_required == 'yes')
                                $output .= ' required';
                            $output .= '/>
                            </div>
                        </div>';
                    }
                    if($field3_active != 'no')
                    {
                        $output .= '
                        <div class="form-group">
                            <label '.$label_style.' class="control-label col-md-3">'.$field3_name;
                            if($field3_required == 'yes')
                                $output .= ' <span class="text-theme">*</span>';
                            $output .= '
                            </label>
                            <div class="col-md-9">
                                <input type="text" name="'.strtolower(str_replace(' ', '_', $field3_name)).'" class="form-control"';
                            if($field3_required == 'yes')
                                $output .= ' required';
                            $output .= '/>
                            </div>
                        </div>';
                    }
                    if($field4_active != 'no')
                    {
                        $output .= '
                        <div class="form-group">
                            <label '.$label_style.' class="control-label col-md-3">'.$field4_name;
                            if($field4_required == 'yes')
                                $output .= ' <span class="text-theme">*</span>';
                            $output .= '
                            </label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="'.strtolower(str_replace(' ', '_', $field4_name)).'" rows="5"';
                            if($field4_required == 'yes')
                                $output .= ' required';
                            $output .= '
                            ></textarea>
                            </div>
                        </div>';
                    }
                    if($captcha_active != 'no'){
                        $output .= '
                            <div class="form-group">
                                <div class="col-md-3 control-label">
                                    <label class="control-label">Captcha <span class="text-theme">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input required class="form-control input-lg" type="text" name="captcha" id="captcha" />
                                </div>
                                <div class="col-md-5">'.
                                    $this->createCaptcha($this->block->get_id())
                                .'</div>'.
                                    $error
                            .'</div>';
                    }
                        $output .= '
                        <div class="form-group">
                            <label '.$label_style.' class="control-label col-md-3"></label>
                            <div class="col-md-9 text-left">
                                <button name="contactform'.$this->block->get_id().'" type="submit" class="btn btn-contact btn-block"';
                                if($email_active == 'no')
                                    $output .= 'style="pointer-events:none !important; background: rgb(165, 164, 164);border: 1px solid rgb(165, 164, 164);"';
                                $output .= '>Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
			</div>
	        ';

	        return $output;
		}
		public function generate_admin_menus()
		{
			
		}
	}
?>