<?php
class unordered_list_block_handler extends  block_handler{
        function info()
        {
            $info['category_name'] = "Bootstrap";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Unordered List";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
        public function generate_admin()
        {
        }
	public function generate_style($active_menu = '')
	{
		include $_SERVER['DOCUMENT_ROOT'].'/builderengine/public/animations/animations.php';

		$background_active = $this->block->data('background_active');
		$background_color = $this->block->data('background_color');
		$background_image = $this->block->data('background_image');

		$text_align = $this->block->data('text_align');
		$text_color = $this->block->data('text_color');
		$custom_css = $this->block->data('custom_css');
		$custom_classes = $this->block->data('custom_classes');

		$active_options = array("color" => "Color", "image" => "Image");
		$text_options = array("left" => "Left", "center" => "Center", "right" => "Right");

		$animation_type = $this->block->data('animation_type');
		$animation_duration = $this->block->data('animation_duration');
		?>
		<div role="tabpanel">

			<ul class="nav nav-tabs" role="tablist" style="margin-left: -20px;">
				<li role="presentation" class="<?if($active_menu == 'style' || $active_menu == '') echo 'active'?>"><a href="#title" aria-controls="text" role="tab" data-toggle="tab">Background Styles</a></li>
				<li role="presentation" class="<?if($active_menu == 'custom' || $active_menu == '') echo 'active'?>"><a href="#text" aria-controls="profession" role="tab" data-toggle="tab">Custom CSS</a></li>
				<li role="presentation" class="<?if($active_menu == 'animation' || $active_menu == '') echo 'active'?>"><a href="#animations" aria-controls="animations" role="tab" data-toggle="tab">Animations</a></li>
			</ul>

			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade <?if($active_menu == 'style' || $active_menu == '') echo 'in active'?>" id="title">
					<?php
					$this->admin_select('background_active', $active_options, 'Active background: ', $background_active);
					$this->admin_input('background_color','text', 'Background color: ', $background_color);
					$this->admin_file('background_image','Background image: ', $background_image);
					$this->admin_select('text_align', $text_options, 'Text align: ', $text_align);
					$this->admin_input('text_color','text', 'Text Color: ', $text_color);
					?>
				</div>
				<div role="tabpanel" class="tab-pane fade <?if($active_menu == 'custom') echo 'in active'?>" id="text">
					<?php
					$this->admin_textarea('custom_css','Custom CSS: ', $custom_css, 4);
					$this->admin_textarea('custom_classes','Custom Classes: ', $custom_classes, 2);
					?>
				</div>
				<div role="tabpanel" class="tab-pane fade <?if($active_menu == 'animation') echo 'in active'?>" id="animations">
					<?php
					$this->admin_select('animation_type', $types,'Animation: ', $animation_type);
					$this->admin_select('animation_duration', $durations,'Animation state: ', $animation_duration);
					?>
				</div>
			</div>

		</div>
		<?php
	}
	public function load_generic_styling()
	{
		$background_active = $this->block->data('background_active');
		$background_color = $this->block->data('background_color');
		$background_image = $this->block->data('background_image');

		$text_align = $this->block->data('text_align');
		$text_color = $this->block->data('text_color');
		$custom_css = $this->block->data('custom_css');

		$animation_type = $this->block->data('animation_type');
		$animation_duration = $this->block->data('animation_duration');

		$this->block->force_data_modification();
		$this->block->add_css_class('animated '.$animation_duration.' '.$animation_type);

		$style_arr = $this->block->data("style");
		if($background_active == 'color')
			$style_arr['background-color'] = $background_color;
		else
			$style_arr['background-image'] = $background_image;
		$style_arr['text-align'] = $text_align;
		$style_arr['color'] = $text_color;
		$style_arr['text'] = ';'.$custom_css;
		$this->block->set_data("style", $style_arr);
	}
		public function set_initial_values_if_empty()
		{
			$content = $this->block->data('content');

			if(!is_array($content) || empty($content))
			{
				$content = array();
				$content[0]['text'] = "Lorem ipsum dolor sit amet.";
				$content[1]['text'] = "Consectetur adipiscing elit.";
				$content[2]['text'] = "Integer molestie lorem at massa.";
				$content[3]['text'] = "Facilisis in pretium nisl aliquet.";

				$this->block->set_data('content', $content, true);
			}
		}
        public function generate_content()
        {
			global $active_controller;
			$CI = &get_instance();
			$CI->load->module('layout_system');

			$this->set_initial_values_if_empty();
			$content = $this->block->data('content');
			$single_element = '<li class="designer-editable" id="remove-0-key_to_replace-'.$this->block->get_id().'" field_name="content-key_to_replace-text">Sample text</li>';

			//generic animations
			$this->load_generic_styling();
			//

			$output = '
			<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
				<ul id="unordered-list-'.$this->block->get_id().'" >';

			foreach($content as $key => $element)
			{
				$element = (object)$element;
				if(!isset($element->text))
					$element->text = "Sample text";
				$output .= '
				<li class="designer-editable" id="remove-0-'.$key.'-'.$this->block->get_id().'" field_name="content-'.$key.'-text">'.$element->text.'</li>';
			}

			$output .='
                </ul>
            ';

			return $output.$CI->layout_system->load_new_block_scripts($this->block->get_id(), 'unordered-list-'.$this->block->get_id(), $CI->BuilderEngine->get_page_path(), $single_element, $this->block->get_name(), 'advanced');
		}
    }
?>