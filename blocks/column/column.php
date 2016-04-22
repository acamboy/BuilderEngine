<?php
class column_block_handler extends  block_handler{
		function info()
		{
			$info['category_name'] = "Page System";
			$info['category_icon'] = "dsf";

			$info['block_name'] = "Column";
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

            $active_options = array("color" => "Color", "image" => "Image");

            $this->admin_select('background_active', $active_options, 'Active background: ', $background_active);
            $this->admin_input('background_color','text', 'Background color: ', $background_color);
            $this->admin_file('background_image','Background image: ', $background_image, 'column'.$this->block->get_id(),true);
            ?>
            <script>
                $("#column<?=$this->block->get_id()?>").click(function(e){
                    e.preventDefault();
                });
            </script>
            <?php
        }
        public function generate_content()
        {
            global $active_controller;
            $CI = &get_instance();
            $CI->load->module('layout_system');

            $background_active = $this->block->data('background_active');
            $background_color = $this->block->data('background_color');
            $background_image = $this->block->data('background_image');

            $output = '
            <script>
                $(document).ready(function(){';
                    if($background_active == 'image')
                        $output .= '$("[name=\''.$this->block->name.'\']").css("background-image", "url('.$background_image.')");';
                    else
                        $output .= '$("[name=\''.$this->block->name.'\']").css("background-color", "'.$background_color.'");';
                $output .= '
                });
            </script>';

            return $output.$CI->layout_system->load_section_script($this->block->get_id(), $CI->BuilderEngine->get_page_path(), 'column', $this->block->get_name());
        }
	}
?>