<?php
    class Recent_posts_block_handler extends  block_handler{
        function info()
        {
            $info['category_name'] = "Blog";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Recent Posts List";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
        public function generate_admin()
        {
            $post_count = $this->block->data('post_count');
            
            $count = array(
                "1" => "1",
                "2" => "2",
                "3" => "3",
                "4" => "4",
                "5" => "5",
				"all" => "All",
                );
            $this->admin_select('post_count', $count, 'Post Count: ', $post_count);
        }
        public function generate_style()
        {
			$path = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/index.php'));
			include $path.'/builderengine/public/animations/animations.php';

            $sections_font_color = $this->block->data('sections_font_color');
            $sections_font_weight = $this->block->data('sections_font_weight');
            $sections_font_size = $this->block->data('sections_font_size');
            $sections_background_color = $this->block->data('sections_background_color');
			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');
            ?>
            <div role="tabpanel">
                <div class="tab-content">
                     <div role="tabpanel" class="tab-pane fade in active" id="sections">
                        <?php
                        $this->admin_input('sections_font_color','text', 'Font color: ', $sections_font_color);
                        $this->admin_input('sections_font_weight','text', 'Font weight: ', $sections_font_weight);
                        $this->admin_input('sections_font_size','text', 'Font size: ', $sections_font_size);
                        $this->admin_input('sections_background_color','text', 'Background color: ', $sections_background_color);
						$this->admin_select('animation_type', $types,'Animation type: ',$animation_type);
						$this->admin_select('animation_duration', $durations,'Animation duration: ',$animation_duration);
						$this->admin_select('animation_event', $events,'Animation Start: ',$animation_event);
						$this->admin_select('animation_delay', $delays,'Animation Delay: ',$animation_delay);
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

            $sections_font_color = $this->block->data('sections_font_color');
            $sections_font_weight = $this->block->data('sections_font_weight');
            $sections_font_size = $this->block->data('sections_font_size');
            $sections_background_color = $this->block->data('sections_background_color');
            $post_count = $this->block->data('post_count');

			$animation = $this->block->data('animation');
			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');
			$settings[0][0] = 'recentitems'.$this->block->get_id();
			$settings[0][1] = $animation_event;
			$settings[0][2] = $animation_duration.' '.$animation_delay.' '.$animation_type;
			add_action("be_foot", generate_animation_events($settings));

            $section_style = 
                'style="
                    background:'.$sections_background_color.' !important;
                "';
            $section_link_style = 
                'style="
                    color: '.$sections_font_color.' !important;
                    font-weight: '.$sections_font_weight.' !important;
                    font-size: '.$sections_font_size.' !important;
                "';
			$section_color = 'style="color:'.$sections_font_color.' !important;"';
            $CI = & get_instance();
            $CI->load->model('post');
            $all_posts = new Post();
			$all = $all_posts->count();
            $BuilderEngine = new BuilderEngine();
            $recent_posts = $all_posts->order_by('time_created','desc');
            $recent_post_limit = $BuilderEngine->get_option('be_blog_num_recent_posts_displayed');
            if($recent_post_limit == '' || $recent_post_limit == 0){
                $recent_post_limit = 5;
            }
            if(isset($post_count)){
				if($post_count == 'all')
					$post_count = $all;
                $recent_post_limit = $post_count;
            }
            $j=1;

            $output = '
					<link href=\"/builderengine/public/animations/css/animate.min.css\" rel=\"stylesheet\" />
                     <link href="'.base_url('blocks/recent_posts/style.css').'" rel="stylesheet">
					<div class="widgetblogrecent" id="blog">
					<div id="recentitems'.$this->block->get_id().'" class="masonry-item-blog-recent" '.$section_style.'>
                        <h4 '.$section_color.'>RECENT BLOGS</h4>
                        <ul class="nav nav-list">';
                        foreach ($recent_posts->get() as $recent_post){
                            if($j <= $recent_post_limit){
                                $output .= '
                                    <li>
                                        <a '.$section_link_style.' href="'.base_url().'blog/post/'.$recent_post->slug.'">
                                            <i class="fa fa-sign-out"></i> 
                                        '.stripslashes($recent_post->title).'</a>
                                        <small '.$section_color.'>'.date('d.M.Y / h:i',$recent_post->time_created).'</small>
                                    </li>';
                                $j++;
                            }
                        }
            $output .= '
                        </ul>
                   </div> </div>';

            return $output.$CI->layout_system->load_new_block_scripts($this->block->get_id(), '', $CI->BuilderEngine->get_page_path(), '', $this->block->get_name(), 'with_settings');
        }
    }
?>