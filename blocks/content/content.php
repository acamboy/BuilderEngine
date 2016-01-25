<?php
class Content_block_handler extends  block_handler{
		function info()
		{
			$info['category_name'] = "Page System";
			$info['category_icon'] = "dsf";

			$info['block_name'] = "Content";
			$info['block_icon'] = "fa-envelope-o";
			
			return $info;
		}
		public function generate_admin()
		{

		}
        public function generate_style()
        {
            $background_active = $this->block->data('background_active');
            $background_color = $this->block->data('background_color');
            $background_image = $this->block->data('background_image');

			$text = $this->block->data('content');
            $active_options = array("color" => "Color", "image" => "Image");
			$this->admin_input('text','text', 'Text: ', $text);
            $this->admin_select('background_active', $active_options, 'Active background: ', $background_active);
            $this->admin_input('background_color','text', 'Background color: ', $background_color);
            $this->admin_file('background_image','Background image: ', $background_image,'content'.$this->block->get_id(),true);
		?>
			<script>
				$("#content<?=$this->block->get_id()?>").click(function(e){
				   e.preventDefault();
				});						
			</script>		
		<?php
        }
		public function generate_content()
		{
	        $this->block->force_data_modification();

	        $style_arr = $this->block->data("style");

            $style_arr['padding-left'] = '0';
            $style_arr['padding-right'] = '0';
	        $this->block->set_data("style", $style_arr);
	        //$output = $this->block->data('content');
			$output = $this->block->data('text');
            $background_active = $this->block->data('background_active');
            $background_color = $this->block->data('background_color');
            $background_image = $this->block->data('background_image');

            $output .= '
            <script>
                $(document).ready(function(){';
                    if($background_active == 'image')
                        $output .= '$("[name=\''.$this->block->name.'\']").css("background-image", "url('.$background_image.')");';
                    else
                        $output .= '$("[name=\''.$this->block->name.'\']").css("background-color", "'.$background_color.'");';
                $output .= '
                });
            </script>';
            return $output;
	        //return $output;
		}
	}
?>