<?php
class title_block_handler extends  block_handler{
        function info()
        {
            $info['category_name'] = "Bootstrap";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Title";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
        public function generate_admin()
        {
			$headings = array(
				'h1' => 'Heading 1',
				'h2' => 'Heading 2',
				'h3' => 'Heading 3',
				'h4' => 'Heading 4',
				'h5' => 'Heading 5',
				'h6' => 'Heading 6',
			);
			$title_text = $this->block->data('title');
			$title_size = $this->block->data('title_size');
			$this->admin_select('title_size', $headings ,'Title size:', $title_size);
			$this->admin_input('title','text', 'Title text: ', $title_text);
        }
        public function generate_style()
        {
			$path = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/index.php'));
			include $path.'/builderengine/public/animations/animations.php';

            $text_font_color = $this->block->data('text_font_color');
            $text_font_weight = $this->block->data('text_font_weight');
            $text_font_size = $this->block->data('text_font_size');
			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');

            $this->admin_input('text_font_color','text', 'Font color: ', $text_font_color);
            $this->admin_input('text_font_weight','text', 'Font weight: ', $text_font_weight);
            $this->admin_input('text_font_size','text', 'Font size: ', $text_font_size);
			$this->admin_select('animation_type', $types,'Animation type: ',$animation_type);
			$this->admin_select('animation_duration', $durations,'Animation duration: ',$animation_duration);
			$this->admin_select('animation_event', $events,'Animation Start: ',$animation_event);
			$this->admin_select('animation_delay', $delays,'Animation Delay: ',$animation_delay);
        }
        public function generate_content()
        {
			$title_text = $this->block->data('title');
			$title_size = $this->block->data('title_size');
            // style
            $text_font_color = $this->block->data('text_font_color');
            $text_font_weight = $this->block->data('text_font_weight');
            $text_font_size = $this->block->data('text_font_size');

			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');
			$settings[0][0] = 'titleb'.$this->block->get_id();
			$settings[0][1] = $animation_event;
			$settings[0][2] = $animation_duration.' '.$animation_delay.' '.$animation_type;
			add_action("be_foot", generate_animation_events($settings));
			
            $text_style = 
                'style="
                    color: '.$text_font_color.' !important;
                    font-weight: '.$text_font_weight.' !important;
                    font-size: '.$text_font_size.' !important;
                "';

            $output = '
				<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
                <'.$title_size.' id="titleb'.$this->block->get_id().'" '.$text_style.'>' .$title_text.'</'.$title_size.'>
            ';

            return $output;
        }
        public function generate_admin_menus()
        {
            
        }
    }
?>