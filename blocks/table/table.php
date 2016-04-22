<?php
class table_block_handler extends  block_handler{
        function info()
        {
            $info['category_name'] = "Bootstrap";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Table";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
        public function generate_admin()
        {
			$title_col_1 = $this->block->data('title_col_1');
			$title_col_2 = $this->block->data('title_col_2');
			$title_col_3 = $this->block->data('title_col_3');
			
			$row1_col_1 = $this->block->data('row1_col_1');
			$row1_col_2 = $this->block->data('row1_col_2');
			$row1_col_3 = $this->block->data('row1_col_3');
			
			$row2_col_1 = $this->block->data('row2_col_1');
			$row2_col_2 = $this->block->data('row2_col_2');
			$row2_col_3 = $this->block->data('row2_col_3');
			
			$row3_col_1 = $this->block->data('row3_col_1');
			$row3_col_2 = $this->block->data('row3_col_2');
			$row3_col_3 = $this->block->data('row3_col_3');		
		?>
			
			<div role="tabpanel">
				<ul class="nav nav-tabs" role="tablist" style="margin-left: -20px;">
					<li role="presentation" class="active"><a href="#first_row" aria-controls="icon" role="tab" data-toggle="tab">Column titles</a></li>
					<li role="presentation"><a href="#first_col" aria-controls="title" role="tab" data-toggle="tab">First Row</a></li>
					<li role="presentation"><a href="#second_col" aria-controls="title" role="tab" data-toggle="tab">Second Row</a></li>
					<li role="presentation"><a href="#third_col" aria-controls="title" role="tab" data-toggle="tab">Third Row</a></li>
				</ul>	
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="first_row">
						<?php
							$this->admin_input('title_col_1','text', 'First Column Title: ', $title_col_1);
							$this->admin_input('title_col_2','text', 'Second Column Title: ', $title_col_2);
							$this->admin_input('title_col_3','text', 'Third Column Title: ', $title_col_3);
						?>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="first_col">
						<?php
							$this->admin_input('row1_col_1','text', 'First Row Col 1: ', $row1_col_1);
							$this->admin_input('row1_col_2','text', 'First Row Col 2: ', $row1_col_2);
							$this->admin_input('row1_col_3','text', 'First Row Col 3: ', $row1_col_3);
						?>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="second_col">
						<?php
							$this->admin_input('row2_col_1','text', 'Second Row Col 1: ', $row2_col_1);
							$this->admin_input('row2_col_2','text', 'Second Row Col 2: ', $row2_col_2);
							$this->admin_input('row2_col_3','text', 'Second Row Col 3: ', $row2_col_3);
						?>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="third_col">
						<?php
							$this->admin_input('row3_col_1','text', 'Third Row Col 1: ', $row3_col_1);
							$this->admin_input('row3_col_2','text', 'Third Row Col 1: ', $row3_col_2);
							$this->admin_input('row3_col_3','text', 'Third Row Col 1: ', $row3_col_3);
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

            $first_row_font_color = $this->block->data('first_row_font_color');
            $first_row_font_weight = $this->block->data('first_row_font_weight');
            $first_row_font_size = $this->block->data('first_row_font_size');
            $first_row_background = $this->block->data('first_row_background');

            $first_col_font_color = $this->block->data('first_col_font_color');
            $first_col_font_weight = $this->block->data('first_col_font_weight');
            $first_col_font_size = $this->block->data('first_col_font_size');
            $first_col_background = $this->block->data('first_col_background');

            $contents_font_color = $this->block->data('contents_font_color');
            $contents_font_weight = $this->block->data('contents_font_weight');
            $contents_font_size = $this->block->data('contents_font_size');
            $contents_background = $this->block->data('contents_background');
			
			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');
            ?>
            <div role="tabpanel">

                <ul class="nav nav-tabs" role="tablist" style="margin-left: -20px;">
                    <li role="presentation" class="active"><a href="#first_row" aria-controls="icon" role="tab" data-toggle="tab">First row</a></li>
                    <li role="presentation"><a href="#first_col" aria-controls="title" role="tab" data-toggle="tab">First column</a></li>
                    <li role="presentation"><a href="#contents" aria-controls="subtitle" role="tab" data-toggle="tab">Table contents</a></li>
					<li role="presentation"><a href="#animations" aria-controls="animations" role="tab" data-toggle="tab">Animations</a></li>
                    <li role="presentation"><a href="#customcss" aria-controls="customcss" role="tab" data-toggle="tab">Custom CSS</a></li>
                </ul>

                <div class="tab-content">
                     <div role="tabpanel" class="tab-pane fade in active" id="first_row">
                        <?php
                        $this->admin_input('first_row_font_color','text', 'Font color: ', $first_row_font_color);
                        $this->admin_input('first_row_font_weight','text', 'Font weight: ', $first_row_font_weight);
                        $this->admin_input('first_row_font_size','text', 'Font size: ', $first_row_font_size);
                        $this->admin_input('first_row_background','text', 'Background color: ', $first_row_background);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="first_col">
                        <?php
                        $this->admin_input('first_col_font_color','text', 'Font color: ', $first_col_font_color);
                        $this->admin_input('first_col_font_weight','text', 'Font weight: ', $first_col_font_weight);
                        $this->admin_input('first_col_font_size','text', 'Font size: ', $first_col_font_size);
                        $this->admin_input('first_col_background','text', 'Background color: ', $first_col_background);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="contents">
                        <?php
                        $this->admin_input('contents_font_color','text', 'Font color: ', $contents_font_color);
                        $this->admin_input('contents_font_weight','text', 'Font weight: ', $contents_font_weight);
                        $this->admin_input('contents_font_size','text', 'Font size: ', $contents_font_size);
                        $this->admin_input('contents_background','text', 'Background color: ', $contents_background);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="animations">
                        <?php
						$this->admin_select('animation_type', $types,'Animation type: ',$animation_type);
						$this->admin_select('animation_duration', $durations,'Animation duration: ',$animation_duration);
						$this->admin_select('animation_event', $events,'Animation Start: ',$animation_event);
						$this->admin_select('animation_delay', $delays,'Animation Delay: ',$animation_delay);
                        ?>
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
            global $active_controller;
            $CI = &get_instance();
            $CI->load->module('layout_system');

            $custom_css = $this->block->data('custom_css');
            $style_arr['text'] = ';'.$custom_css;
            $this->block->set_data("style", $style_arr);

			$title_col_1 = $this->block->data('title_col_1');
			$title_col_2 = $this->block->data('title_col_2');
			$title_col_3 = $this->block->data('title_col_3');
			
			$row1_col_1 = $this->block->data('row1_col_1');
			$row1_col_2 = $this->block->data('row1_col_2');
			$row1_col_3 = $this->block->data('row1_col_3');
			
			$row2_col_1 = $this->block->data('row2_col_1');
			$row2_col_2 = $this->block->data('row2_col_2');
			$row2_col_3 = $this->block->data('row2_col_3');
			
			$row3_col_1 = $this->block->data('row3_col_1');
			$row3_col_2 = $this->block->data('row3_col_2');
			$row3_col_3 = $this->block->data('row3_col_3');

            if(empty($title_col_1))
                $title_col_1 = 'Text';
            if(empty($title_col_2))
                $title_col_2 = 'Text';
            if(empty($title_col_3))
                $title_col_3 = 'Text';
            if(empty($row1_col_1))
                $row1_col_1 = 'Text';
            if(empty($row1_col_2))
                $row1_col_2 = 'Text';
            if(empty($row1_col_3))
                $row1_col_3 = 'Text';
            if(empty($row2_col_1))
                $row2_col_1 = 'Text';
            if(empty($row2_col_2))
                $row2_col_2 = 'Text';
            if(empty($row2_col_3))
                $row2_col_3 = 'Text';
            if(empty($row3_col_1))
                $row3_col_1 = 'Text';
            if(empty($row3_col_2))
                $row3_col_2 = 'Text';
            if(empty($row3_col_3))
                $row3_col_3 = 'Text';

            // Style
            $first_row_font_color = $this->block->data('first_row_font_color');
            $first_row_font_weight = $this->block->data('first_row_font_weight');
            $first_row_font_size = $this->block->data('first_row_font_size');
            $first_row_background = $this->block->data('first_row_background');

            $first_col_font_color = $this->block->data('first_col_font_color');
            $first_col_font_weight = $this->block->data('first_col_font_weight');
            $first_col_font_size = $this->block->data('first_col_font_size');
            $first_col_background = $this->block->data('first_col_background');

            $contents_font_color = $this->block->data('contents_font_color');
            $contents_font_weight = $this->block->data('contents_font_weight');
            $contents_font_size = $this->block->data('contents_font_size');
            $contents_background = $this->block->data('contents_background');

			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');

			$settings[0][0] = 'table'.$this->block->get_id();
			$settings[0][1] = $animation_event;
			$settings[0][2] = $animation_duration.' '.$animation_delay.' '.$animation_type;
			add_action("be_foot", generate_animation_events($settings));

            $first_row_style = 
                'style="
                    color: '.$first_row_font_color.' !important;
                    font-weight: '.$first_row_font_weight.' !important;
                    font-size: '.$first_row_font_size.' !important;
                    background-color: '.$first_row_background.' !important;
                "';
            $first_col_style = 
                'style="
                    color: '.$first_col_font_color.' !important;
                    font-weight: '.$first_col_font_weight.' !important;
                    font-size: '.$first_col_font_size.' !important;
                    background-color: '.$first_col_background.' !important;
                "';
            $contents_style = 
                'style="
                    color: '.$contents_font_color.' !important;
                    font-weight: '.$contents_font_weight.' !important;
                    font-size: '.$contents_font_size.' !important;
                    background-color: '.$contents_background.' !important;
                "';

            $output = '
			<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
                <table id="table'.$this->block->get_id().'" class="table table-bordered">
                    <thead>
                        <tr>
                            <th '.$first_row_style.'>#</th>
                            <th '.$first_row_style.'>'.$title_col_1.'</th>
                            <th '.$first_row_style.'>'.$title_col_2.'</th>
                            <th '.$first_row_style.'>'.$title_col_3.'</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th '.$first_col_style.' scope="row">1</th>
                            <td '.$contents_style.'>'.$row1_col_1.'</td>
                            <td '.$contents_style.'>'.$row1_col_2.'</td>
                            <td '.$contents_style.'>'.$row1_col_3.'</td>
                        </tr>
                        <tr>
                            <th '.$first_col_style.' scope="row">2</th>
                            <td '.$contents_style.'>'.$row2_col_1.'</td>
                            <td '.$contents_style.'>'.$row2_col_2.'</td>
                            <td '.$contents_style.'>'.$row2_col_3.'</td>
                        </tr>
                        <tr>
                            <th '.$first_col_style.' scope="row">3</th>
                            <td '.$contents_style.'>'.$row3_col_1.'</td>
                            <td '.$contents_style.'>'.$row3_col_2.'</td>
                            <td '.$contents_style.'>'.$row3_col_3.'</td>
                        </tr>
                    </tbody>
                </table>
            ';

            return $output.$CI->layout_system->load_new_block_scripts($this->block->get_id(), 'table'.$this->block->get_id(), $CI->BuilderEngine->get_page_path(), '', $this->block->get_name(), 'with_settings');
        }
    }
?>