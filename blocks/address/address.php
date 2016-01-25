<?php
class address_block_handler extends  block_handler{
        function info()
        {
            $info['category_name'] = "Bootstrap";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Address";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
        public function generate_admin()
        {
            $line_1 = $this->block->data('line_1');
            $line_2 = $this->block->data('line_2');
            $line_3 = $this->block->data('line_3');	
			$line_4 = $this->block->data('line_4');
			?>
           <style>
            #settings-content .form-group
            {
                margin-left:0px !important;
                width:90% !important;
            }
            </style>
                <ul id="myTab" class="nav nav-tabs" style="margin-left:-15px">
                    <li class="active"><a href="#general" data-toggle="tab">Address: </a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="general">
                        <?php $this->admin_input('line_1','text', 'Name: ', $line_1);?>
						<?php $this->admin_input('line_2','text', 'Street: ', $line_2);?>
						<?php $this->admin_input('line_3','text', 'City and zip: ', $line_3);?>
						<?php $this->admin_input('line_4','text', 'Phone number: ', $line_4);?>
                    </div>
				</div>
			<?php
        }
        public function generate_style()
        {
			$path = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/index.php'));
			include $path.'/builderengine/public/animations/animations.php';
			
            $line_1_font_color = $this->block->data('line_1_font_color');
            $line_1_font_weight = $this->block->data('line_1_font_weight');
            $line_1_font_size = $this->block->data('line_1_font_size');

            $line_2_font_color = $this->block->data('line_2_font_color');
            $line_2_font_weight = $this->block->data('line_2_font_weight');
            $line_2_font_size = $this->block->data('line_2_font_size');

            $line_3_font_color = $this->block->data('line_3_font_color');
            $line_3_font_weight = $this->block->data('line_3_font_weight');
            $line_3_font_size = $this->block->data('line_3_font_size');

            $line_4_font_color = $this->block->data('line_4_font_color');
            $line_4_font_weight = $this->block->data('line_4_font_weight');
            $line_4_font_size = $this->block->data('line_4_font_size');

			$address_animation_type = $this->block->data('address_animation_type');	  
		    $address_animation_duration = $this->block->data('address_animation_duration');
		    $address_animation_event = $this->block->data('address_animation_event');
		    $address_animation_delay = $this->block->data('address_animation_delay');
            ?>
            <div role="tabpanel">

                <ul class="nav nav-tabs" role="tablist" style="margin-left: -20px;">
                    <li role="presentation" class="active"><a href="#line_1" aria-controls="icon" role="tab" data-toggle="tab">Name </a></li>
                    <li role="presentation"><a href="#line_2" aria-controls="title" role="tab" data-toggle="tab">Street Address</a></li>
                    <li role="presentation"><a href="#line_3" aria-controls="subtitle" role="tab" data-toggle="tab">City and Zip</a></li>
                    <li role="presentation"><a href="#line_4" aria-controls="background" role="tab" data-toggle="tab">Phone</a></li>
					<li role="presentation"><a href="#animations" aria-controls="animations" role="tab" data-toggle="tab">Animations</a></li>
                </ul>

                <div class="tab-content">
                     <div role="tabpanel" class="tab-pane fade in active" id="line_1">
                        <?php
                        $this->admin_input('line_1_font_color','text', 'Font color: ', $line_1_font_color);
                        $this->admin_input('line_1_font_weight','text', 'Font weight: ', $line_1_font_weight);
                        $this->admin_input('line_1_font_size','text', 'Font size: ', $line_1_font_size);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="line_2">
                        <?php
                        $this->admin_input('line_2_font_color','text', 'Font color: ', $line_2_font_color);
                        $this->admin_input('line_2_font_weight','text', 'Font weight: ', $line_2_font_weight);
                        $this->admin_input('line_2_font_size','text', 'Font size: ', $line_2_font_size);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="line_3">
                        <?php
                        $this->admin_input('line_3_font_color','text', 'Font color: ', $line_3_font_color);
                        $this->admin_input('line_3_font_weight','text', 'Font weight: ', $line_3_font_weight);
                        $this->admin_input('line_3_font_size','text', 'Font size: ', $line_3_font_size);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="line_4">
                        <?php
                        $this->admin_input('line_4_font_color','text', 'Font color: ', $line_4_font_color);
                        $this->admin_input('line_4_font_weight','text', 'Font weight: ', $line_4_font_weight);
                        $this->admin_input('line_4_font_size','text', 'Font size: ', $line_4_font_size);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="animations">
                        <?php
						$this->admin_select('address_animation_type', $types,'Animation type: ',$address_animation_type);
						$this->admin_select('address_animation_duration', $durations,'Animation duration: ',$address_animation_duration);
						$this->admin_select('address_animation_event', $events,'Animation Start: ',$address_animation_event);
						$this->admin_select('address_animation_delay', $delays,'Animation Delay: ',$address_animation_delay);
                        ?>
                    </div>
                </div>

            </div>
            <?php
        }
        public function generate_content()
        {
            // style
            $line_1_font_color = $this->block->data('line_1_font_color');
            $line_1_font_weight = $this->block->data('line_1_font_weight');
            $line_1_font_size = $this->block->data('line_1_font_size');

            $line_2_font_color = $this->block->data('line_2_font_color');
            $line_2_font_weight = $this->block->data('line_2_font_weight');
            $line_2_font_size = $this->block->data('line_2_font_size');

            $line_3_font_color = $this->block->data('line_3_font_color');
            $line_3_font_weight = $this->block->data('line_3_font_weight');
            $line_3_font_size = $this->block->data('line_3_font_size');

            $line_4_font_color = $this->block->data('line_4_font_color');
            $line_4_font_weight = $this->block->data('line_4_font_weight');
            $line_4_font_size = $this->block->data('line_4_font_size');

			$address_animation_state = $this->block->data('address_animation_state');
			$address_animation_type = $this->block->data('address_animation_type');	  
		    $address_animation_duration = $this->block->data('address_animation_duration');
		    $address_animation_event = $this->block->data('address_animation_event');
		    $address_animation_delay = $this->block->data('address_animation_delay');
			
            $line_1 = $this->block->data('line_1');
            $line_2 = $this->block->data('line_2');
            $line_3 = $this->block->data('line_3');	
			$line_4 = $this->block->data('line_4');

			$settings[0][0] = 'address'.$this->block->get_id();
			$settings[0][1] = $address_animation_event;
			$settings[0][2] = $address_animation_duration.' '.$address_animation_delay.' '.$address_animation_type;
			add_action("be_foot", generate_animation_events($settings));
			
			if(empty($line_1))
				$line_1 = 'Some Company , Inc';
			if(empty($line_2))
				$line_2 = 'Example Street 244';
			if(empty($line_3))
				$line_3 = 'Brand New York, 35442';
			if(empty($line_4))
				$line_4 = '(02) 233-4323';
            $line_1_style = 
                'style="
                    color: '.$line_1_font_color.' !important;
                    font-weight: '.$line_1_font_weight.' !important;
                    font-size: '.$line_1_font_size.' !important;
                "';
            $line_2_style = 
                'style="
                    color: '.$line_2_font_color.' !important;
                    font-weight: '.$line_2_font_weight.' !important;
                    font-size: '.$line_2_font_size.' !important;
                "';
            $line_3_style = 
                'style="
                    color: '.$line_3_font_color.' !important;
                    font-weight: '.$line_3_font_weight.' !important;
                    font-size: '.$line_3_font_size.' !important;
                "';
            $line_4_style = 
                'style="
                    color: '.$line_4_font_color.' !important;
                    font-weight: '.$line_4_font_weight.' !important;
                    font-size: '.$line_4_font_size.' !important;
                "';
            
            $output = '
			<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
				<div id="address'.$this->block->get_id().'">
					<address>
						<strong '.$line_1_style.'>'.$line_1.'</strong><br>
						<span '.$line_2_style.'>'.$line_2.'</span><br>
						<span '.$line_3_style.'>'.$line_3.'</span><br>
						<span '.$line_4_style.'><abbr title="Phone">Phone: </abbr> '.$line_4.'</span>
					</address>
				</div>
            ';

            return $output;
        }
        public function generate_admin_menus()
        {
            
        }
    }
?>