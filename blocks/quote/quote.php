<?php
class quote_block_handler extends  block_handler{
    function info()
    {
        $info['category_name'] = "Core";
        $info['category_icon'] = "dsf";

        $info['block_name'] = "Quote";
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
			$style_arr['background-size'] = '100% 100%';
			$style_arr['background-repeat'] = 'no-repeat';
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
            $content[0] = new stdClass();
            $content[0]->quotation = 'Passion leads to design, design leads to performance, performance leads to success!';
            $content[0]->from = 'Web Guru';
            $content[0]->author = 'Sean Murphy ';

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
		$text_color = $this->block->data('text_color');
		$color = 'style="color:'.$text_color.' !important;"';
        $single_element = '';

        //generic animations
        $this->load_generic_styling();
        //

        $output = '';
        foreach($content as $key => $element)
        {
            $element = (object)$element;
			$class='';
			if($this->block->data('background_active') == 'image' && !empty($this->block->data('background_image')) || $this->block->data('background_active') == 'color' && empty($this->block->data('background-color'))){
				$class='';
			}else{
				$class='has-bg';
			}
            $output .= '
			<link href="'.base_url('blocks/quote/style.css').'" rel="stylesheet">
			<div id="quote-container-'.$this->block->get_id().'" class="blockcontent-quote bg-black-darker '.$class.'" data-scrollview="true">
				<div class="content-bg"></div>
				<div class="" data-animation="true" data-animation-type="fadeInLeft">
					<div class="row">
						<div>
							<i class="fa fa-quote-left"></i>
							<span '.$color.' field_name="content-'.$key.'-quotation" class="designer-editable" id="quote-quotation-'.$this->block->get_id().'">'.$element->quotation.'</span>
							<i class="fa fa-quote-right"></i>
							<small>
								<div '.$color.' field_name="content-'.$key.'-author" class="designer-editable" id="quote-author-'.$this->block->get_id().'">'.$element->author.'</div>
								<div '.$color.' field_name="content-'.$key.'-from" class="designer-editable" id="quote-from-'.$this->block->get_id().'">, '.$element->from.'</div>
							</small>
						</div>
					</div>
				</div>
			</div>';
        }

        return $output.$CI->layout_system->load_new_block_scripts($this->block->get_id(), 'quote-container-'.$this->block->get_id(), $CI->BuilderEngine->get_page_path(), $single_element, $this->block->get_name(), 'style');
    }

}
?>