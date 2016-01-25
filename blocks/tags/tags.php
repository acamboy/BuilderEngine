<?php
    class Tags_block_handler extends  block_handler{
        function info()
        {
            $info['category_name'] = "Blog";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Blog Tags";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
        public function generate_admin()
        {
            $tags_count = $this->block->data('tags_count');
            $alphabetical_order_tags = $this->block->data('alphabetical_order_tags');
            
            $count = array(
                "1" => "1",
                "2" => "2",
                "3" => "3",
                "4" => "4",
                "5" => "5",
                "all" => "All"
                );

            $option = array(
                "yes" => "Yes",
                "no" => "No"
                );
            $this->admin_select('tags_count', $count, 'Post Count: ', $tags_count);
            $this->admin_select('alphabetical_order_tags', $option, 'Alphabetical Order (a-z): ', $alphabetical_order_tags);
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
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        public function generate_content()
        {
            $sections_font_color = $this->block->data('sections_font_color');
            $sections_font_weight = $this->block->data('sections_font_weight');
            $sections_font_size = $this->block->data('sections_font_size');
            $sections_background_color = $this->block->data('sections_background_color');
            $tags_count = $this->block->data('tags_count');
            $alphabetical_order_tags = $this->block->data('alphabetical_order_tags');

			$animation_type = $this->block->data('animation_type');	  
		    $animation_duration = $this->block->data('animation_duration');
		    $animation_event = $this->block->data('animation_event');
		    $animation_delay = $this->block->data('animation_delay');
			$settings[0][0] = 'tags'.$this->block->get_id();
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
			$section_h4_color = 'style="color:'.$sections_font_color.' !important;"';
            $output = '
				<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
                <link href="'.base_url('blocks/tags/style.css').'" rel="stylesheet">
				<div class="widgetblogtags" id="blog">
				<div id="tags'.$this->block->get_id().'" class="masonry-item-blog-tags" '.$section_style.'>
                    <h4 '.$section_h4_color.'>BLOG TAGS</h4>';
                    $BuilderEngine = new BuilderEngine();
                    $CI = & get_instance();
                    $CI->load->model('post');
                    $posts = new Post();

                    $posts = $posts->order_by('time_created', 'desc')->get();
                    $available_tags = array();
                    $set_limit = $BuilderEngine->get_option('be_blog_num_tags_displayed');
                    if($set_limit == '' || $set_limit == 0)
                        $set_limit = 12;
                    foreach($posts as $post)
                    {
                        $tags = explode(',',$post->tags);    
                        foreach($tags as $tag)
                        {
                            array_push($available_tags,$tag);
                        }
                    }
                    if(isset($tags_count)){
                        if($tags_count == 'all')
                        {
                            $set_limit = count($available_tags);
                        }else{
                            $set_limit = $tags_count;
                        }
                    }
                    $available_tags = array_unique($available_tags);
                    $available_tags = array_slice($available_tags,0,$set_limit);

                    if($alphabetical_order_tags == 'yes')
                        asort($available_tags);

                    foreach($available_tags as $tag){
                        $output .= '
                            <a class="label label-default light tagsblock" href="'.base_url('blog/search/'.$tag).'" '.$section_link_style.'><i class="fa fa-tags"></i> '.$tag.'</a>';
                    }
            $output .= '
                        <div class="clearfix"></div>
                   </div> </div>';
            return $output;
        }
        public function generate_admin_menus()
        {
        }
    }
?>