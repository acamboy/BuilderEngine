<?php
    class Category_posts_block_handler extends  block_handler{
        function info()
        {
            $info['category_name'] = "Blog";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Category Posts";
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
                "yes" => "Yes",
                "no" => "No"
                );
            
            $category_option = array(
                "all" => "All"
                );
            $categores = new Category();
            $all_category = $categores->get();
            foreach ($all_category->all as $key => $value) {
                $category_option[$value->id] = $value->name;
            }

            $this->admin_select('post_count', $count, 'Post Count: ', $post_count);
            $this->admin_select('alphabetical_order', $option, 'Alphabetical Order (a-z): ', $alphabetical_order);
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
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        public function generate_content()
        {

            $CI = & get_instance();
            $CI->load->model('visits');
            $sequence = $CI->visits->populyar_post_by_visits();

            $sections_font_color = $this->block->data('sections_font_color');
            $sections_font_weight = $this->block->data('sections_font_weight');
            $sections_font_size = $this->block->data('sections_font_size');
            $sections_background_color = $this->block->data('sections_background_color');
            $post_count = $this->block->data('post_count');
            $alphabetical_order = $this->block->data('alphabetical_order');
            $category = $this->block->data('category');

			$sections_animation_type = $this->block->data('sections_animation_type');	  
		    $sections_animation_duration = $this->block->data('sections_animation_duration');
		    $sections_animation_event = $this->block->data('sections_animation_event');
		    $sections_animation_delay = $this->block->data('sections_animation_delay');
			$settings[0][0] ='category'.$this->block->get_id();
			$settings[0][1] = $sections_animation_event;
			$settings[0][2] = $sections_animation_duration.' '.$sections_animation_delay.' '.$sections_animation_type;
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

            $users = new User();
            $all_posts = new Post();
            $all_category = new Category();
            $BuilderEngine = new BuilderEngine();

            $recent_posts = $all_posts->order_by('time_created','desc');

            if($category == 'all' || intval($category) == 0){
                $recent_posts = $recent_posts->get();
            }else{
                $recent_posts = $recent_posts->get_where(array('category_id' => intval($category)));
            }
            $recent_post_limit = $BuilderEngine->get_option('be_blog_posts_per_page');
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

            if($alphabetical_order == 'yes')
                ksort($sequence);

            $output = '<div class="row">
                <div '.$section_style.' class="masonry-list">';

            $i = 1;
            foreach ($sequence as $key => $value) {
                foreach($recent_posts as $post){
                    if($key == $post->slug){
                        if($i <= $recent_post_limit){
                            $user = $users->get_by_id($post->user_id);
                            $output .= '
							<link href="'.base_url('blocks/category_posts/style.css').'" rel="stylesheet">
							<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
							<div class="col-md-6" id="blog">
                                <li class="masonry-item-blog-category-post"  '.$section_style.'>
                                    <div class="item" id="category'.$this->block->get_id().'">
                                        <div class="item-title blog-header-small">
                                            <h2><a '.$section_link_style.' href="'.base_url('/blog/post').'/'.$post->slug.'"> '.$post->title.'</a></h2>  
											<small class="space14">';
                                                $post_comments = array();
                                                $CI = & get_instance();
                                                $CI->load->model('comment');
                                                $comments = new Comment;
                                                foreach($comments->where('post_id',$post->id)->get() as $comment)
                                                    {array_push($post_comments,$comment->id);}
                                                $num_comments = count($post_comments);
                                                $pluralizer = ($num_comments == 1) ? 'Comment' : 'Comments' ;
                                        $output .= '                                          
                                            <a href="/blog/post/'.$post->slug.'#comments" class="label label-default light"><i class="fa fa-comment-o"></i> '.$num_comments.''.$pluralizer.'</a>
                                            <span class="label label-default light">'.date('M d, Y', $post->time_created).'</span> 
											<a class="label label-default light pull-right"><i>Post by: </i> '.$user->username.' </a>
                                        </div>

                                        <figure>
                                            <a href="/blog/post/'.$post->slug.'"><img src="'.$post->image.'" class="img-responsive thumbnail" alt="" /></a>
                                        </figure>';
                                            $text_without_slashes = ChEditorfix($post->text);
                                            if(strlen($post->text) > 300)
                                            {
                                                $text = substr($text_without_slashes, 0, 300).'...';
                                            }
                                            else{
                                                $text = $text_without_slashes;
                                            }
                                    $output .= '<div style="word-wrap: break-word;">'.$text.'</div>
                                        <a href="/blog/post/'.$post->slug.'" class="btn-primary btn-xs pull-right"><i class="fa fa-sign-out"></i> READ MORE..</a>
                                    </div>
                                
                                </li></div>';
                            $i++;
                        }
                    }
                }
            }
            $output .= '
                </div></div>';
            return $output;
        }
        public function generate_admin_menus()
        {
        }
    }
?>