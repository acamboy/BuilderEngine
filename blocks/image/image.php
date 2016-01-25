<?php
class image_block_handler extends  block_handler{
        function info()
        {
            $info['category_name'] = "Bootstrap";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Image";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
        public function generate_admin()
        {
            $image_url = $this->block->data('image_url');
            $this->admin_file('image_url','Add Image: ', $image_url,'imgblock'.$this->block->get_id(),true);
		?>
			<script>
				$("#imgblock<?=$this->block->get_id()?>").click(function(e){
				   e.preventDefault();
				});						
			</script>		
		<?php
        }
        public function generate_style()
        {
			$path = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/index.php'));
			include $path.'/builderengine/public/animations/animations.php';

            $image_width = $this->block->data('image_width');
            $image_float = $this->block->data('image_float');

			$image_animation_type = $this->block->data('image_animation_type');	  
		    $image_animation_duration = $this->block->data('image_animation_duration');
		    $image_animation_event = $this->block->data('image_animation_event');
		    $image_animation_delay = $this->block->data('image_animation_delay');
			
            $alignments = array(
                "left" => "Left",
                "right" => "Right",
                "center" => "Center",
                );
            $this->admin_input('image_width','text', 'Width: ', $image_width);
            $this->admin_select('image_float', $alignments, 'Alignment: ', $image_float);
			$this->admin_select('image_animation_type', $types,'Animation type: ',$image_animation_type);
			$this->admin_select('image_animation_duration', $durations,'Animation duration: ',$image_animation_duration);
			$this->admin_select('image_animation_event', $events,'Animation Start: ',$image_animation_event);
			$this->admin_select('image_animation_delay', $delays,'Animation Delay: ',$image_animation_delay);
        }
        public function generate_content()
        {
            $image_url = $this->block->data('image_url');

            $image_width = $this->block->data('image_width');
            $image_float = $this->block->data('image_float');
			$image_animation_state = $this->block->data('image_animation_state');
			$image_animation_type = $this->block->data('image_animation_type');	  
		    $image_animation_duration = $this->block->data('image_animation_duration');
		    $image_animation_event = $this->block->data('image_animation_event');
		    $image_animation_delay = $this->block->data('image_animation_delay');

			$settings[0][0] = 'image'.$this->block->get_id();
			$settings[0][1] = $image_animation_event;
			$settings[0][2] = $image_animation_duration.' '.$image_animation_delay.' '.$image_animation_type;
			add_action("be_foot", generate_animation_events($settings));

            if($image_width == '')
                $image_width = '100%';
            if($image_url == '')
                $image_url = '/blocks/image/images/placeholder.jpg';

            if($image_float == 'left')
                $image_float = 'float:left !important;';
            elseif($image_float == 'right')
                $image_float = 'float:right !important;';
            else
                $image_float = 'margin: 0 auto; !important;';
            $output = '
                <link href="'.base_url('blocks/image/style.css').'" rel="stylesheet">
				<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
				<a href="#" class="thumbnail" style="pointer-events:none;background-color:transparent;border:none;max-height:100%;">
                    <img id="image'.$this->block->get_id().'" src="'.$image_url.'" style="'.$image_float.'width:'.$image_width.'">
                </a>
            ';

            return $output;
        }
        public function generate_admin_menus()
        {
            
        }
    }
?>