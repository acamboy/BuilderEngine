<?php
	class dynamic_table_block_handler extends block_handler{

        function info()
        {
            $info['category_name'] = "Bootstrap";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Dynamic Table";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
        public function generate_admin()
        {
			$rows = $this->block->data('rows');
			$cols = $this->block->data('cols');
			$titles = $this->block->data('titles');
			$fields = $this->block->data('fields');
			?>				
				<div role="tabpanel">
					<ul class="nav nav-tabs" role="tablist" style="margin-left: -20px;">
						<li role="presentation" class="active"><a href="#first_row" aria-controls="icon" role="tab" data-toggle="tab">Summary</a></li>
						<li role="presentation"><a href="#first_col" aria-controls="title" role="tab" data-toggle="tab">Column titles</a></li>
						<li role="presentation"><a href="#second_col" aria-controls="title" role="tab" data-toggle="tab">Data Fields</a></li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="first_row">
							<?php
								$this->admin_input('rows','text', 'Rows: ', $rows);
								$this->admin_input('cols','text', 'Columns: ', $cols);
							?>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="first_col">
							<?php 
							for($i=0;$i<$cols;$i++){
								$this->admin_input('titles['.$i.']','text', 'Column '.$num = $i+1 .': ', $titles[$i]);
							}
							?>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="second_col">
							<?php $f=0;
							for($i=0;$i<$rows;$i++){
								for($j=0;$j<$cols;$j++){
									$this->admin_input('fields['.$f.']','text', 'Row '.$frow = $i+1 .' Col '.$fcol = $j+1 .': ', $fields[$f]);
									$f++;
								}
								$f++;
							}
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
			
			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');
			
			$this->admin_select('animation_type', $types,'Animation type: ',$animation_type);
			$this->admin_select('animation_duration', $durations,'Animation duration: ',$animation_duration);
			$this->admin_select('animation_event', $events,'Animation Start: ',$animation_event);
			$this->admin_select('animation_delay', $delays,'Animation Delay: ',$animation_delay);
			$custom_css = $this->block->data('custom_css');
			$custom_classes = $this->block->data('custom_classes');
			$this->admin_textarea('custom_css','Custom CSS: ', $custom_css, 4);
			$this->admin_textarea('custom_classes','Custom Classes: ', $custom_classes, 2);
        }
        public function generate_content()
        {
			global $active_controller;
			$CI = &get_instance();
			$CI->load->module('layout_system');

			$custom_css = $this->block->data('custom_css');
			$style_arr['text'] = ';'.$custom_css;
			$this->block->set_data("style", $style_arr);

			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');

			$settings[0][0] = 'dyntable'.$this->block->get_id();
			$settings[0][1] = $animation_event;
			$settings[0][2] = $animation_duration.' '.$animation_delay.' '.$animation_type;
			add_action("be_foot", generate_animation_events($settings));
			
			$rows = $this->block->data('rows');
			$cols = $this->block->data('cols');
			$titles = $this->block->data('titles');
			$fields = $this->block->data('fields');
			$this->block->force_data_modification();
			
			$output = '
						<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
						<table id="dyntable'.$this->block->get_id().'" class="table table-striped table-hover table-bordered">
							<thead>
								<th>#</th>';
									for($z=0;$z<$cols;$z++){
										$output .='<th>'.$titles[$z] .'</th>';
									}
				$output .=	'</thead>';
								$f=0;
								for($i=0;$i<$rows;$i++){
									$output .= '<tr>';
									$output .='<td>'.$num = $i+1 .'</td>';
									for($j=0;$j<$cols;$j++){
										$output .='<td>'.$fields[$f].'</td>';
										$f++;
									}
									$f++;
									$output .='</tr>';
								}
			$output .= '</table>';

			return $output.$CI->layout_system->load_new_block_scripts($this->block->get_id(), 'dyntable'.$this->block->get_id(), $CI->BuilderEngine->get_page_path(), '', $this->block->get_name(), 'with_settings');
        }
    }
?>