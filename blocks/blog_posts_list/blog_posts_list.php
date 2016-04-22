<?php
    class Blog_posts_list_block_handler extends  block_handler{
        function info()
        {
            $info['category_name'] = "Blog";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Blog Posts List";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
        public function generate_admin()
        {
            $post_count = $this->block->data('post_count');
            $alphabetical_order = $this->block->data('alphabetical_order');
            $category = $this->block->data('category');
            
            $count = array(
                "1" => "1",
                "2" => "2",
                "3" => "3",
                "4" => "4",
                "5" => "5",
                "all" => "All"
                );

            $option = array(
                "az" => "Alphabetical from A to Z",
                "za" => "Alphabetical from Z to A",
				"latest" => "Latest posts",
				"oldest" => "Oldest posts",
				"updated" => "Updated posts",
				"most_visited" => "Most visited",
				"less_visited" => "Less visited"
                );
            
            $category_option = array(
                "all" => "All"
                );
            $categores = new Category();
            $all_category = $categores->get();
            foreach ($all_category->all as $key => $value) {
                $category_option[$value->id] = stripslashes($value->name);
            }

            $this->admin_select('post_count', $count, 'Post Count: ', $post_count);
            $this->admin_select('alphabetical_order', $option, 'Posts order: ', $alphabetical_order);
            $this->admin_select('category', $category_option, 'Category: ', $category);
        }
        public function generate_style()
        {
			$path = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/index.php'));
			include $path.'/builderengine/public/animations/animations.php';
            $sections_font_color = $this->block->data('sections_font_color');
            $sections_font_weight = $this->block->data('sections_font_weight');
            $sections_font_size = $this->block->data('sections_font_size');
            $sections_background_color = $this->block->data('sections_background_color');
			$sections_animation_type = $this->block->data('sections_animation_type');	  
		    $sections_animation_duration = $this->block->data('sections_animation_duration');
		    $sections_animation_event = $this->block->data('sections_animation_event');
		    $sections_animation_delay = $this->block->data('sections_animation_delay');
            ?>
            <div role="tabpanel">
                <div class="tab-content">
                     <div role="tabpanel" class="tab-pane fade in active" id="sections">
                        <?php
                        $this->admin_input('sections_font_color','text', 'Font color: ', $sections_font_color);
                        $this->admin_input('sections_font_weight','text', 'Font weight: ', $sections_font_weight);
                        $this->admin_input('sections_font_size','text', 'Font size: ', $sections_font_size);
                        $this->admin_input('sections_background_color','text', 'Background color: ', $sections_background_color);
						$this->admin_select('sections_animation_type', $types,'Animation type: ',$sections_animation_type);
						$this->admin_select('sections_animation_duration', $durations,'Animation duration: ',$sections_animation_duration);
						$this->admin_select('sections_animation_event', $events,'Animation Start: ',$sections_animation_event);
						$this->admin_select('sections_animation_delay', $delays,'Animation Delay: ',$sections_animation_delay);
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

            $CI->load->model('visits');
            $sequence = $CI->visits->populyar_post_by_visits();

            $custom_css = $this->block->data('custom_css');
            $style_arr['text'] = ';'.$custom_css;
            $this->block->set_data("style", $style_arr);

            $sections_font_color = $this->block->data('sections_font_color');
            $sections_font_weight = $this->block->data('sections_font_weight');
            $sections_font_size = $this->block->data('sections_font_size');
            $sections_background_color = $this->block->data('sections_background_color');
			$sections_animation_type = $this->block->data('sections_animation_type');	  
		    $sections_animation_duration = $this->block->data('sections_animation_duration');
		    $sections_animation_event = $this->block->data('sections_animation_event');
		    $sections_animation_delay = $this->block->data('sections_animation_delay');
			$settings[0][0] ='blog_list';
			$settings[0][1] = $sections_animation_event;
			$settings[0][2] = $sections_animation_duration.' '.$sections_animation_delay.' '.$sections_animation_type;
			add_action("be_foot", generate_animation_events($settings));
            $post_count = $this->block->data('post_count');
            $alphabetical_order = $this->block->data('alphabetical_order');
            $category = $this->block->data('category');

            $section_style = 
                'style="
                    background: '.$sections_background_color.' !important;
                "';
            $section_link_style = 
                'style="
                    color: '.$sections_font_color.' !important;
                    font-weight: '.$sections_font_weight.' !important;
                    font-size: '.$sections_font_size.' !important;
                "';

            $all_posts = new Post();
            $all_category = new Category();
            $BuilderEngine = new BuilderEngine();

            $recent_posts = $all_posts->order_by('time_created','desc');
            // out(intval($category));
            if($category == 'all' || intval($category) == 0){
                $recent_posts = $recent_posts->get();
            }else{
                $recent_posts = $recent_posts->get_where(array('category_id' => intval($category)));
            }
            $recent_post_limit = $BuilderEngine->get_option('be_blog_num_recent_posts_displayed');
            if($recent_post_limit == '' || $recent_post_limit == 0){
                $recent_post_limit = 5;
            }
            if(isset($post_count)){
                if($post_count == 'all')
                {
                    $recent_post_limit = count($recent_posts->all);
                }else{
                    $recent_post_limit = $post_count;
                }
            }

            if($alphabetical_order == 'az')//ok
                ksort($sequence);
            if($alphabetical_order == 'za')//ok
				krsort($sequence);
            if($alphabetical_order == 'oldest')
				$recent_posts = $all_posts->order_by('time_created','asc')->get();
            if($alphabetical_order == 'latest')//ok
				rsort($sequence);
            if($alphabetical_order == 'updated')
				$recent_posts = $all_posts->order_by('time_created','desc')->get();
            if($alphabetical_order == 'most_visited')//ok
				arsort($sequence);
            if($alphabetical_order == 'less_visited')//ok
				asort($sequence);

            $output = '
                    <link href="'.base_url('blocks/blog_posts_list/style.css').'" rel="stylesheet">
					<div class="widgetbloglist" id="blog_list">
					<div class="masonry-item-blog-list" '.$section_style.'>
                        <h4>BLOG POSTS</h4>
                        <ul class="nav nav-list">';
                        $j=1;
						if($alphabetical_order != 'oldest'){
							foreach ($sequence as $key => $value) {
								foreach ($recent_posts as $recent_post){
									if($key == $recent_post->slug)
										if($j <= $recent_post_limit){
											$output .= '
												<li>
													<a '.$section_link_style.' href="'.base_url().'blog/post/'.$recent_post->slug.'">
														<i class="fa fa-sign-out"></i>  
													'.stripslashes($recent_post->title).'</a>
													<small>'.date('d.M.Y / h:i',$recent_post->time_created).'</small>
												</li>';
											$j++;
										}
								}
							}
						}else{
                            foreach ($recent_posts as $recent_post){
                                    if($j <= $recent_post_limit){
                                        $output .= '
                                            <li>
                                                <a '.$section_link_style.' href="'.base_url().'blog/post/'.$recent_post->slug.'">
                                                    <i class="fa fa-sign-out"></i>  
                                                '.stripslashes($recent_post->title).'</a>
                                                <small>'.date('d.M.Y / h:i',$recent_post->time_created).'</small>
                                            </li>';
                                        $j++;
                                    }
                            }							
						}
            $output .= '
                        </ul>
                  </div>   </div>';

            return $output.$CI->layout_system->load_new_block_scripts($this->block->get_id(), '', $CI->BuilderEngine->get_page_path(), '', $this->block->get_name(), 'with_settings');
        }
    }
?>