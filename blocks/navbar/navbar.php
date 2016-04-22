<?php
class navbar_block_handler extends  block_handler{
        function info()
        {
            $info['category_name'] = "Core";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Navbar";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
        public function generate_admin()
        {
            ?>
            <style>
                #block-admin-save
                {
                    display:none;
                }
                .navbar-dashboard-link
                {
                    color: #3A80A1 !important;
                    text-decoration: none;
                    transition:all 0.5s ease;
                }
                .navbar-dashboard-link:hover
                {
                    color: #60C4F3 !important;
                }
            </style>
            <h2 style="color: #fff;"> To edit the contents of this navbar click <a class="navbar-dashboard-link" href="<?=base_url('/admin/links/show')?>">here</a></h2>
            <?php
        }
        public function generate_style()
        {
			$path = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/index.php'));
			include $path.'/builderengine/public/animations/animations.php';

            $sections_font_color = $this->block->data('sections_font_color');
            $sections_font_weight = $this->block->data('sections_font_weight');
            $sections_font_size = $this->block->data('sections_font_size');
            $sections_background_color = $this->block->data('sections_background_color');

            $subsections_font_color = $this->block->data('subsections_font_color');
            $subsections_font_weight = $this->block->data('subsections_font_weight');
            $subsections_font_size = $this->block->data('subsections_font_size');
            $subsections_background_color = $this->block->data('subsections_background_color');

			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');

            ?>
            <div role="tabpanel">

                <ul class="nav nav-tabs" role="tablist" style="margin-left: -20px;">
                    <li role="presentation" class="active"><a href="#sections" aria-controls="sections" role="tab" data-toggle="tab">Links</a></li>
                    <li role="presentation"><a href="#subsections" aria-controls="subsections" role="tab" data-toggle="tab">Dropdown links</a></li>
					<li role="presentation"><a href="#animations" aria-controls="animations" role="tab" data-toggle="tab">Animations</a></li>
                    <li role="presentation"><a href="#customcss" aria-controls="customcss" role="tab" data-toggle="tab">Custom CSS</a></li>
                </ul>

                <div class="tab-content">
                     <div role="tabpanel" class="tab-pane fade in active" id="sections">
                        <?php
                        $this->admin_input('sections_font_color','text', 'Font color: ', $sections_font_color);
                        $this->admin_input('sections_font_weight','text', 'Font weight: ', $sections_font_weight);
                        $this->admin_input('sections_font_size','text', 'Font size: ', $sections_font_size);
                        $this->admin_input('sections_background_color','text', 'Background color: ', $sections_background_color);
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="subsections">
                        <?php
                        $this->admin_input('subsections_font_color','text', 'Font color: ', $subsections_font_color);
                        $this->admin_input('subsections_font_weight','text', 'Font weight: ', $subsections_font_weight);
                        $this->admin_input('subsections_font_size','text', 'Font size: ', $subsections_font_size);
                        $this->admin_input('subsections_background_color','text', 'Background color: ', $subsections_background_color);
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

            // style
            $sections_font_color = $this->block->data('sections_font_color');
            $sections_font_weight = $this->block->data('sections_font_weight');
            $sections_font_size = $this->block->data('sections_font_size');
            $sections_background_color = $this->block->data('sections_background_color');

            $subsections_font_color = $this->block->data('subsections_font_color');
            $subsections_font_weight = $this->block->data('subsections_font_weight');
            $subsections_font_size = $this->block->data('subsections_font_size');
            $subsections_background_color = $this->block->data('subsections_background_color');

			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');

			$settings[0][0] = 'header-navbar-'.$this->block->get_id();
			$settings[0][1] = $animation_event;
			$settings[0][2] = $animation_duration.' '.$animation_delay.' '.$animation_type;
			add_action("be_foot", generate_animation_events($settings));
			
            $section_style = 
                'style="
                    background:'.$sections_background_color.' !important;
                "';
            $section_link_style = 
                'style="
                    color:'.$sections_font_color.' !important;
                    font-weight: '.$sections_font_weight.' !important;
                    font-size: '.$sections_font_size.' !important;
                "';
            $subsection_style = 
                'style="
                    background-color: '.$subsections_background_color.' !important;
                "';
            $subsection_link_style = 
                'style="
                    color: '.$subsections_font_color.' !important;
                    font-weight: '.$subsections_font_weight.' !important;
                    font-size: '.$subsections_font_size.' !important;
                "';

            $output = '
				<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
                <link href="'.base_url('blocks/navbar/style.css').'" rel="stylesheet">
                <div class="navbar-header custom-content">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="header-navbar" style="background-color: transparent !important;">
                    <ul '.$section_style.' class="nav navbar-nav navbar-right" id="header-navbar-'.$this->block->get_id().'">';
                    foreach(get_links() as $link)
                    {
                        $output .= '
                        <li class="dropdown">';
                        if(count($link->childs) > 0)
                        {
                            $output .= '
                            <a '.$section_link_style.' href="'.$link->target.'" title="'.$link->title.'" class="dropdown-toggle" data-toggle="dropdown">
                                '.$link->name.'
                                <b class="caret"></b>                           
                            </a>
                            <ul '.$subsection_style.' class="dropdown-menu dropdown-menu-left animated fadeIn" style="z-index:10000">';
                            foreach($link->childs as $sub_link)
                            {
                                $output .= '
                                <li><a '.$subsection_link_style.' href="'.$sub_link->target.'" title="'.$link->title.'">'.$sub_link->name.'</a></li>';
                            }
                            $output .=
                            '</ul>';
                        }
                        else
                            $output .= '<a '.$section_link_style.' href="'.$link->target.'" title="'.$link->title.'">'.$link->name.'</a>';
                        $output .= '
                        </li>';
                    }
                    $output .= '
                    </ul>
                </div>';

            return $output.$CI->layout_system->load_new_block_scripts($this->block->get_id(), 'navbar-'.$this->block->get_id(), $CI->BuilderEngine->get_page_path(), '', $this->block->get_name(), 'with_settings');
        }
    }
?>