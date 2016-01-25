<?php
    class Blog_posts_block_handler extends  block_handler{
        function info()
        {
            $info['category_name'] = "Blog";
            $info['category_icon'] = "dsf";

            $info['block_name'] = "Blog Posts";
            $info['block_icon'] = "fa-envelope-o";
            
            return $info;
        }
        public function generate_admin()
        {
            $post = $this->block->data('post');
            
            $posts_option = array();
            $CI = & get_instance();
            $CI->load->model('post');
            $posts = $CI->post;
            $all_posts = $posts->get();
            foreach ($all_posts->all as $key => $value) {
                $posts_option[$value->id] = $value->title;
            }
            $this->admin_select('post', $posts_option, 'Posts: ', $post);
        }
        public function generate_style()
        {
			$path = substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/index.php'));
			include $path.'/builderengine/public/animations/animations.php';

            $sections_font_color = $this->block->data('sections_font_color');
            $sections_background_color = $this->block->data('sections_background_color');
			$sections_animation_type = $this->block->data('sections_animation_type');	  
		    $sections_animation_duration = $this->block->data('sections_animation_duration');
		    $sections_animation_event = $this->block->data('sections_animation_event');
		    $sections_animation_delay = $this->block->data('sections_animation_delay');
            // $sections_font_weight = $this->block->data('sections_font_weight');
            // $sections_font_size = $this->block->data('sections_font_size');
            ?>
            <div role="tabpanel">
                <div class="tab-content">
                     <div role="tabpanel" class="tab-pane fade in active" id="sections">
                        <?php
                        $this->admin_input('sections_font_color','text', 'Font color: ', $sections_font_color);
                        $this->admin_input('sections_background_color','text', 'Background color: ', $sections_background_color);
						$this->admin_select('sections_animation_type', $types,'Animation type: ',$sections_animation_type);
						$this->admin_select('sections_animation_duration', $durations,'Animation duration: ',$sections_animation_duration);
						$this->admin_select('sections_animation_event', $events,'Animation Start: ',$sections_animation_event);
						$this->admin_select('sections_animation_delay', $delays,'Animation Delay: ',$sections_animation_delay);
                        // $this->admin_input('sections_font_weight','text', 'Font weight: ', $sections_font_weight);
                        // $this->admin_input('sections_font_size','text', 'Font size: ', $sections_font_size);
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        public function generate_content()
        {
            $post_id = $this->block->data('post');
            $sections_font_color = $this->block->data('sections_font_color');
            $sections_background_color = $this->block->data('sections_background_color');
			$sections_animation_type = $this->block->data('sections_animation_type');	  
		    $sections_animation_duration = $this->block->data('sections_animation_duration');
		    $sections_animation_event = $this->block->data('sections_animation_event');
		    $sections_animation_delay = $this->block->data('sections_animation_delay');
			$settings[0][0] ='blog';
			$settings[0][1] = $sections_animation_event;
			$settings[0][2] = $sections_animation_duration.' '.$sections_animation_delay.' '.$sections_animation_type;
			add_action("be_foot", generate_animation_events($settings));

            $section_style = 
                'style="
                    background:'.$sections_background_color.' !important;
                "';
            $section_link_style = 
                'style="
                    color:'.$sections_font_color.' !important;
                "';

            $CI = & get_instance();
            $CI->load->library('session');
            $CI->load->library('form_validation');
            $BuilderEngine = new BuilderEngine();
            $user = new User();
            $users = new Users();
            $CI->load->model('post');
            $post = $CI->post;
            $post = $post->where('id', $post_id)->get();
            $CI->load->model('comment');
            $comments = $CI->comment;
            $comments = $comments->where('post_id',$post->id)->get();
            $pub_user = $user->get_by_id($post->user_id);
            $output = '
                <link href="'.base_url('blocks/blog_posts/style.css').'" rel="stylesheet">
				<link href="'.base_url('builderengine/public/animations/css/animate.min.css').'" rel="stylesheet" />
				<div class="left" id="blog">
				<li class="masonry-item" '.$section_style.'>
                    <header class="blog-post">
                       <a href="'.base_url('blog/post').'/'.$post->slug.'"> <h1 '.$section_link_style.'>Blog: '.$post->title.'</h1></a>
                        <small class="space18">';
                            $post_comments=array();
                            foreach($comments as $comment)
                                {array_push($post_comments,$comment->id);}
                        $count = count($post_comments);
                        $pluralizer = ($count == 1) ? 'Comment' : 'Comments';
                        $output .= '
                            <a href="'.base_url('blog/post').'/'.$post->slug.'" class="scrollTo label label-default light"> <i class="fa fa-comment-o"></i> '.$count.' '.$pluralizer.'</a>
                            <span class="label label-default light">'.date('d.M.Y',$post->time_created).'</span> 
                            <span class="label label-default pull-right"><span><i>Post by:</i></span> <span class="light" ><a href="#">'.$pub_user->username.'</a></span></span>
                        </small>
                    </header>';

                    if(!empty($post->image)){
                        $output .= '
                            <div class="item" style="padding-bottom:0px">
                                <a href="'.base_url('blog/post').'/'.$post->slug.'"><img src="'.$post->image.'" class="img-responsive blogimage-fullwidth thumbnail" alt="img" /></a>
                            </div>';
                    }
            $output .= '
				<link href="'.base_url('blocks/blog_posts/style.css').'" rel="stylesheet">               
			   <article>
                   '.ChEditorfix($post->text).'
                </article>

                <hr />';

                    if($BuilderEngine->get_option('be_blog_show_tags') != 'no'){
                        $output .= '
                            <p class="space16"> <b>Blog Tags:</b>';
                                foreach($post as $item){
                                    if($item->tags != ''){
                                        $tags = explode(',',$item->tags);
                                        foreach($tags as $tag){
                                            $output .= '
                                                <a class="label label-default light" href="'.base_url('blog/search/'.$tag).'" ><i class="fa fa-tags"></i> '.$tag.'</a> ';
                                        }
                                    }else{
                                        $output .= '-';
                                    }
                                }
                        $output .= '
                           </li> <div class="clearfix"></div>
                        </p>';
                    }
            $output .= '<div class="divider"></div>';
                $comments_alowed = 'no';foreach( $post->stored as $key => $val ){ if( $key == 'comments_allowed' && $val == 'yes'){ $comments_alowed = 'yes';}}
                // if($comments_alowed == 'yes' && $BuilderEngine->get_option('be_blog_allow_comments') != 'no'){
                //     $output .= '
                //         <div id="comments">
                //             <h4>'.$count.' '.$pluralizer.'</h4>';
                //             $i = 1;
                //             foreach($comments as $comment){
                //                 $output .= '
                //                     <div class="comment">
                //                         <span class="user-avatar">';
                //                         if($comment->user_id == 0 || $comment->user_id == ''){
                //                             $output .= '<img class="pull-left media-object" src="'.get_theme_path().'/images/avatars/no_avatar.jpg" width="64" height="64" alt="">';
                //                         }else{
                //                             $commenter = new User($comment->user_id);
                //                             $allow_avatar = new Setting();
                //                             if(isset($allow_avatar->get_user_settings($comment->user_id)->all[0]->allow_avatar) && $allow_avatar->get_user_settings($comment->user_id)->all[0]->allow_avatar != 0)
                //                                 $allow_avatar = 1;
                //                             else
                //                                 $allow_avatar = 0;
                //                             if((!isset($commenter->avatar) || $commenter->avatar == '') || !intval($allow_avatar)){
                //                                 $output .= '<img class="pull-left media-object" src="'.get_theme_path().'/images/avatars/no_avatar.jpg" width="64" height="64" alt="">';
                //                             }else{
                //                                 $output .= '<img class="pull-left media-object" src="'.base_url().''.$commenter->avatar.'" width="64" height="64" alt="">';
                //                             }
                //                         }
                //                 $output .= '
                //                     </span>

                //                     <div class="media-body">
                //                         <h3 class="media-heading bold">'.$comment->name.'</h3>
                //                         <small class="block">'.date('d.M.Y - h:i',$comment->time_created).'</small>
                //                         <br/>
                //                         '.$comment->text.'
                //                     </div>

                //                     <div class="btn-group pull-right" role="group">
                //                         <a href="#commentForm" data-toggle="modal" data-target="#report'.$i.'" class="btn btn-danger blogPostBtn">Report</a>';
                //                         if($users->is_admin()){
                //                             $output .= '<a href="javascript:;" data-id="'.$comment->id.'" class="btn btn-danger blogPostBtn delete-comment">Delete</a>';
                //                         }
                //                 $output .= '
                //                     </div>
                //                     <!-- Modal -->
                //                     <div class="modal fade" id="report'.$i.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                //                         <div class="modal-dialog" style="z-index:10">
                //                             <div class="modal-content">
                //                                 <div class="modal-header">
                //                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                //                                     <h4 class="modal-title" id="myModalLabel">Report Comment</h4>
                //                                 </div>
                //                                 <form method="get" action="'.base_url('blog/report_comment').'">
                //                                     <div class="modal-body">
                //                                         <input type="hidden" name="comment_id" value="'.$comment->id.'">
                //                                         <p>Please describe what aspect of this comment or it`s author you find inadequate, inappropriate or insulting</p>
                //                                         <div class="form-group">
                //                                             <textarea class="form-control" name="text" placeholder="Describe your reason for reporting this comment"></textarea>
                //                                         </div>
                //                                     </div>
                //                                     <div class="modal-footer">
                //                                         <button type="button" class="btn btn-default blogPostBtn" data-dismiss="modal">Close</button>
                //                                         <button type="submit" class="btn btn-primary blogPostBtn">Report</button>
                //                                     </div>
                //                                 </form>
                //                             </div>
                //                         </div>
                //                     </div>
                //                 </div>';
                //                 $i++;
                //             }
                //             if($BuilderEngine->get_option('be_blog_comments_private') == 'private'){
                //                 if(!($CI->session->userdata('user_id') == 0)){
                //                     $output .= '
                //                         <br/>
                //                         <div class="divider"></div>
                //                         <h4>Leave a comment</h4>
                //                         <form id="commentForm" action="'.base_url().'blog/post/'.$post->slug.'" class="form-horizontal" method="post">
                //                             <input type="hidden" name="post_id" value="'.$post->id.'">
                //                             <div class="row">
                //                                 <div class="col-md-12">
                //                                     <textarea required class="form-control input-lg" id="comment" name="text" rows="5" placeholder="Your Comment">'.$CI->form_validation->set_value('text').'</textarea>
                //                                     '.form_error('text').'
                //                                 </div>
                //                             </div>
                //                             <br>';
                //                             $check_captcha = $BuilderEngine->get_option('be_blog_captcha') == 'yes';
                //                             if($check_captcha){
                //                                 $output .= '
                //                                     <div class="row">
                //                                         <div class="col-md-2">
                //                                             <label>Captcha *</label>
                //                                         </div>
                //                                         <div class="col-md-3">
                //                                             <input required class="form-control input-lg" type="text" name="captcha" id="captcha" />
                //                                         </div>
                //                                         <div class="col-md-4">
                //                                             '.$this->createCaptcha().'
                //                                         </div>
                //                                         <div class="clearfix"></div>
                //                                         '.form_error('captcha').'
                //                                     </div>';
                //                             }
                //                         $output .= '
                //                             <div class="row">
                //                                 <div class="col-md-12">
                //                                     <p><button class="btn btn-primary blogPostBtn">Post Comment</button></p>
                //                                 </div>
                //                             </div>
                //                         </form>';
                //                 }
                //             }else{
                //                 $output .= '
                //                 <br/>
                //                 <div class="divider"></div>
                //                 <h4>Leave a comment</h4>
                //                 <form id="commentForm" class="form-horizontal" method="post">
                //                     <div class="row">
                //                         <input type="hidden" name="post_id" value="'.$post->id.'">';
                //                         if($CI->session->userdata('user_id') == 0){
                //                             $output .= '
                //                                 <div class="col-md-4">
                //                                     <label>Name *</label>
                //                                     <input required class="form-control input-lg" type="text" name="name" id="author" value="'.$CI->form_validation->set_value('name').'" />
                //                                     '.form_error('name').'
                //                                 </div>';
                //                         }
                //                 $output .= '
                //                     </div>
                //                     <div class="row">
                //                         <div class="col-md-12">
                //                             <textarea required class="form-control input-lg" id="comment" name="text" rows="5" placeholder="Your Comment">'.$CI->form_validation->set_value('text').'</textarea>
                //                             '.form_error('text').'
                //                         </div>
                //                     </div>
                //                     <br>';
                //                     $check_captcha = $BuilderEngine->get_option('be_blog_captcha') == 'yes';
                //                     if($check_captcha){
                //                         $output .= '
                //                             <div class="row">
                //                                 <div class="col-md-2">
                //                                     <label>Captcha *</label>
                //                                 </div>
                //                                 <div class="col-md-3">
                //                                     <input required class="form-control input-lg" type="text" name="captcha" id="captcha" />
                //                                 </div>
                //                                 <div class="col-md-4">
                //                                     '.$this->createCaptcha().'
                //                                 </div>
                //                                 <div class="clearfix"></div>
                //                                 '.form_error('captcha').'
                //                             </div>';
                //                     }
                //                 $output .= '
                //                     <div class="row">
                //                         <div class="col-md-12">
                //                             <p><button class="btn btn-primary">Post Comment</button></p>
                //                         </div>
                //                     </div>
                //                 </form>';
                //             }
                //     $output .= '</div>';
                // }
            $output .= '</div>';
            if($users->is_admin()){
                $output .= '
                    <div class="modal fade" id="delete-comment" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" style="z-index:10">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Delete comment</h4>
                                </div>
                                <form method="post" action="'.base_url('blog/deleteComment').'">
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this comment?</p>
                                        <input type="hidden" name="comment_id">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default blogPostBtn" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary blogPostBtn">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                ';
            }
            return $output;
        }
        public function generate_admin_menus()
        {
        }
    }
?>