<?php
/**
 * Created by PhpStorm.
 * User: krastevd
 * Date: 2/22/15
 * Time: 01:47
 */

class generic_block_handler extends  block_handler{
    function info()
    {

        return array();
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
        $this->add_class_toggle_option('test_toggle', '<i class="fa fa-arrows-h" rel="tooltip" data-placement="bottom" title="Boxed / Full Width"></i>', 'inverse', true);
        $this->add_class_toggle_option('collapse_toggle', '<i class="fa fa-minus collapse-section" rel="tooltip" data-placement="bottom" title="Minimize / Maximize"></i>', 'inverse', false);
        $this->add_select_option('position', '<i class="fa fa-arrows-v" rel="tooltip" data-placement="bottom" title="Position Type"></i>', array('default' => array('display_name' => 'Default'),'fixed_top' => array('display_name' => 'Fixed Top')), false);
    }
    public function generate_admin()
    {

    }
    public function save_content($content)
    {

    }
    public function generate_style()
    {
		$path = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/index.php'));
		include $path.'/builderengine/public/animations/animations.php';
		
        $background_active = $this->block->data('background_active');
        $background_color = $this->block->data('background_color');
        $background_image = $this->block->data('background_image');

        $text_align = $this->block->data('text_align');
        $text_color = $this->block->data('text_color');
        $custom_css = $this->block->data('custom_css');

        $active_options = array("color" => "Color", "image" => "Image");
        $text_options = array("left" => "Left", "center" => "Center", "right" => "Right");
		
		$animation_type = $this->block->data('animation_type');
		$animation_duration = $this->block->data('animation_duration');
            ?>
            <div role="tabpanel">

                <ul class="nav nav-tabs" role="tablist" style="margin-left: -20px;">
                    <li role="presentation" class="active"><a href="#title" aria-controls="text" role="tab" data-toggle="tab">Background Styles</a></li>
                    <li role="presentation"><a href="#text" aria-controls="profession" role="tab" data-toggle="tab">Custom CSS</a></li>
					<li role="presentation"><a href="#animations" aria-controls="animations" role="tab" data-toggle="tab">Animations</a></li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="title">
                        <?php
                            $this->admin_select('background_active', $active_options, 'Active background: ', $background_active);
                            $this->admin_input('background_color','text', 'Background color: ', $background_color);
                            $this->admin_file('background_image','Background image: ', $background_image,'generic'.$this->block->get_id(),true);
                        ?>
						<script>
							$("#generic<?=$this->block->get_id()?>").click(function(e){
							   e.preventDefault();
							});						
						</script>						
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="text">
                        <?php
                            $this->admin_select('text_align', $text_options, 'Active background: ', $text_align);
                            $this->admin_input('text_color','text', 'Text Color: ', $text_color);
                            $this->admin_textarea('custom_css','Custom CSS: ', $custom_css);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="animations">
                        <?php
						$this->admin_select('animation_type', $types,'Animation: ', $animation_type);
						$this->admin_select('animation_duration', $durations,'Animation state: ', $animation_duration);
                        ?>
                    </div>
                </div>

            </div>
            <?php
    }
    public function generate_content()
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
	   
	   $output = $this->block->data('content');

        return $output;
    }
}
?>

