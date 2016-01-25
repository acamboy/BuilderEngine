<?php
class footer_block_handler extends  block_handler{
		function info()
		{
			$info['category_name'] = "Page System";
			$info['category_icon'] = "dsf";

			$info['block_name'] = "Footer";
			$info['block_icon'] = "fa-envelope-o";
			
			return $info;
		}
		public function admin_option_toggle_test_toggle($toggled)
        {
            $this->block->force_data_modification(true);
            PC::toggled($toggled);

            if($toggled){
                $this->block->remove_css_class('container-fluid');
                $this->block->add_css_class('container');
                PC::toggled("truee");

            }
            else
            {
                $this->block->remove_css_class('container');
                $this->block->add_css_class('container-fluid');
                PC::toggled("falsee");

            }
            $this->block->save();
        }
        public function admin_option_toggle_collapse_toggle($toggled)
        {
            $this->block->force_data_modification(true);
            PC::toggled($toggled);

            if($toggled){
                $this->block->add_css_class('minimized-section');
                PC::toggled("truee");

            }
            else
            {
                $this->block->remove_css_class('minimized-section');
                PC::toggled("falsee");

            }
            $this->block->save();
        }
        public function admin_option_select_position($choice)
        {
            $this->block->force_data_modification(true);
            switch($choice)
            {
                case 'default':
                    $this->block->remove_css_class('be-position-fixed-top');
                    break;
                case 'fixed_top':
                    echo '<Br>putting fixed top<br>';
                    $this->block->add_css_class('be-position-fixed-top');
                    break;
            }
            $this->block->save();
        }

        public function register_admin_options()
        {
            $this->add_class_toggle_option('test_toggle', '<i class="fa fa-arrows-h" rel="tooltip" data-placement="top" title="Boxed / Full Width"></i>', 'inverse', false);
            $this->add_class_toggle_option('collapse_toggle', '<i class="fa fa-minus collapse-section" rel="tooltip" data-placement="top" title="Minimize / Maximize"></i>', 'inverse', false);
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
            $this->admin_file('background_image','Add Background image: ', $background_image, 'footer'.$this->block->get_id(), true);
		?>
			<script>
				$("#footer<?=$this->block->get_id()?>").click(function(e){
				   e.preventDefault();
				});						
			</script>		
		<?php
        }
		public function generate_content()
		{
            /*$background_active = $this->block->data('background_active');
            $background_color = $this->block->data('background_color');
            $background_image = $this->block->data('background_image');

		    $output = '
            <script>
                $(document).ready(function(){';
                    if($background_active == 'image')
                        $output .= '$("#footer-content-styler").parent().parent().css("background-image", "url('.$background_image.')");';
                    else
                        $output .= '$("#footer-content-styler").parent().parent().css("background-color", "'.$background_color.'");';
                $output .= '
                });
            </script>
            <div id="footer-content-styler"></div>';

            return $output;*/
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
            return $output;
		}
	}
?>
