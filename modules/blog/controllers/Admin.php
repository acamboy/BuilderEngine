<?php
    class Admin extends BE_Controller
    {
        // [MenuItem ("Blog/Posts/Add")]
        public function add_post()
        {
            $this->modify_object('post');
        }
        // [MenuItem ("Blog/Posts/Show")]
        public function show_posts()
        {
            $this->show_objects('post');
        }
        // [MenuItem ("Blog/Categories/Add")]
        public function add_category()
        {
            $this->modify_object('category');
        }
        // [MenuItem ("Blog/Categories/Show")]
        public function show_categories()
        {
            $this->show_objects('category');
        }
        // [MenuItem ("Blog/Reports/Comment Reports")]
        public function show_comment_reports()
        {
            $this->show_objects('comment_report');
        }
        
        public function modify_object($object_type, $object_id = -1)
        {
            $object = $this->get_object($object_type, $object_id);
            
            if($_POST)
            {
                $object->create($_POST);
                redirect(base_url('/index.php/admin/module/blog/show_objects/'.$object_type), 'location');
            }
            
            $data['view'] = $this->get_view($object_type,  $object_id);
            $data['title'] = ucfirst($object_type);
			$data['current_page'] = 'blog';
			$data['current_child_page'] = $object_type;
            $this->load->view('backend/modify_object', $data);
        }

        public function delete_object($object_type, $object_id)
        {
            $object = $this->get_object($object_type, $object_id);
            $object->delete();
            redirect(base_url('/index.php/admin/module/blog/show_objects/'.$object_type), 'location');
        }

        public function get_object($object_type, $object_id = -1, $get = false)
        {
            $this->load->model($object_type);
            $object = new $object_type($object_id);

            if($get == true)
                return $object->get();
            else
                return $object;
        }

        public function get_view($object_type, $object_id = -1)
        {
            $view_name = 'add_'.$object_type;

            if($object_id == -1)
                $data['page'] = 'Add';
            else
                $data['page'] = 'Edit';

            $data['object'] = $this->get_object($object_type, $object_id);
            $view = $this->load->view('backend/'.$view_name, $data, true);
            return $view;
        }

        public function show_objects($object_type)
        {

            $user = new users();
            $group_id = $user->get_user_group_ids(get_active_user_id());
            $condition = false;
            if($object_type == 'post')
            {
                foreach ($group_id as $key => $value) {
                    if($user->get_group_by_id($value)->allow_posts == '1')
                        $condition = true;
                }
            } elseif ( $object_type == 'category' ) {
                foreach ($group_id as $key => $value) {
                    if($user->get_group_by_id($value)->allow_categories == '1')
                        $condition = true;
                }
            }

            $data['objects'] = $this->get_object($object_type, '', true);
            $data['condition'] = $condition;
			$data['current_page'] = 'blog';
			$data['current_child_page'] = $object_type;
            $this->load->view('backend/show_'.$object_type.'_objects', $data);
        }
        // [MenuItem ("Blog/Settings/General Settings")]
        public function settings()
        {
            if($_POST)
            {
                $this->BuilderEngine->set_option('be_blog_allow_comments', $this->input->post('allow_comments', true));
                $this->BuilderEngine->set_option('be_blog_comments_private', $this->input->post('comments_private', true));
                $this->BuilderEngine->set_option('be_blog_captcha', $this->input->post('captcha', true));
                $this->BuilderEngine->set_option('be_blog_show_tags', $this->input->post('show_tags', true));
                $this->BuilderEngine->set_option('be_blog_num_tags_displayed', $this->input->post('num_tags_displayed', true));
                $this->BuilderEngine->set_option('be_blog_num_recent_posts_displayed', $this->input->post('num_recent_posts_displayed', true));
                $this->BuilderEngine->set_option('be_blog_num_posts_displayed', $this->input->post('num_posts_displayed', true));
                $this->BuilderEngine->set_option('be_blog_access_groups', $this->input->post('access_groups', true));
                //$this->BuilderEngine->set_option('be_blog_default_module', $_POST['default_module']);
            }
			$data['current_page'] = 'blog';
			$data['current_child_page'] = 'blog_settings';
            $this->load->view('backend/blog_settings',$data); 
        }

        public function show_report($id){
            $comment_report = new Comment_report();
            $data = array(
                'report' => $comment_report->where('id',$id)->get()->all[0]
                );
            $this->load->view('backend/show_report',$data);
        }

        public function delete_comment($id)
        {
            $comment = new Comment($id);
			$comment_reports = new Comment_report();
			foreach($comment_reports->where('comment_id',$id)->get() as $comment_report){
				$comment_report->delete();
			}
            $comment->delete();
            redirect(base_url('/admin/module/blog/show_objects/comment_report'), 'location');
        }
        public function delete_report($id)
        {
            $comment_report = new Comment_report($id);
            $comment_report->delete();
            redirect(base_url('/admin/module/blog/show_objects/comment_report'), 'location');
        }
    }
?>