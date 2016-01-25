<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends Module_Controller {

    public function category($id)
    {
        $category = new Category($id);

        $page_number = 1;
        if(isset($_GET['page']))
        {
            $page_number = $_GET['page'];
        }
        if(!$this->BuilderEngine->get_option('be_blog_num_posts_displayed'))
        {
            $posts_per_page = 6;
        }
        else
            $posts_per_page = $this->BuilderEngine->get_option('be_blog_num_posts_displayed');

        $data['category'] = $category;
        $data['posts'] = $category->post->order_by('time_created', 'desc')->get_paged($page_number, $posts_per_page);
        $data['categories'] = $this->get_categories();
        $this->load->view('frontend/category', $data);
    }

    public function all_posts()
    {
        $posts = new Post();

        $page_number = 1;
        if(isset($_GET['page']))
        {
            $page_number = $_GET['page'];
        }
        if(!$this->BuilderEngine->get_option('be_blog_num_posts_displayed'))
        {
            $posts_per_page = 6;
        }
        else
            $posts_per_page = $this->BuilderEngine->get_option('be_blog_num_posts_displayed');

        $data['posts'] = $posts->order_by('time_created', 'desc')->get_paged($page_number, $posts_per_page);
        $data['categories'] = $this->get_categories();
        $this->load->view('frontend/all_posts', $data);
    }

    public function search($keyword = null)
    {
        $keyword = urldecode($keyword);
        $posts = new Post();
        if(isset($_GET['keyword']))
        {
            redirect(base_url('/blog/search/'.$_GET['keyword']), 'location');
        }

        $page_number = 1;
        if(isset($_GET['page']))
        {
            $page_number = $_GET['page'];
        }
        if(!$this->BuilderEngine->get_option('be_blog_num_posts_displayed'))
        {
            $posts_per_page = 6;
        }
        else
            $posts_per_page = $this->BuilderEngine->get_option('be_blog_num_posts_displayed');
        
        $data['categories'] = $this->get_categories();
        $data['posts'] = $posts->like('title', $keyword)->or_like('tags', $keyword)->or_like('text', $keyword)->order_by('time_created', 'desc')->get_paged($page_number, $posts_per_page);
        $data['keyword'] = $keyword;
        $this->load->view('frontend/search', $data);
    }

    public function report_comment()
    {
		$comment = new Comment($_POST['comment_id']);
		$comment->report($_POST['text']);
		redirect(base_url('/blog/post/'.$comment->post->get()->slug), 'location');
    }

    public function post($slug = null)
    {
        $this->load->helper(array('form', 'url','captcha'));
        $this->load->library('form_validation');
        if($_POST)
        {
            if($this->validate_comment()){
                
                if(!$this->user->is_guest())
                {
                    $user = new User($this->user->get_id());
                    $user_id = $user->id;
                    $user_name = $user->username;
                }
                else
                {
                    $user_id = 0;
                    $user_name = $this->input->post('name');
                }
                  
                $data = array(
                    'user_id' => $user_id,
                    'name' => $user_name,
                    'post_id' =>  $this->input->post('post_id', true),
                    'text'       =>  $this->input->post('text', true)
                );
                
                $comment = new Comment();
                $comment->create($data);
                redirect('blog/post/'.$slug);
            }
        }

        $original_string = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
        $original_string = implode("", $original_string);
        $captcha = substr(str_shuffle($original_string), 0, 6);

         //Field validation failed.  User redirected to login page
        $vals = array(
            'word' => $captcha,
            'img_path' => './files/captcha/',
            'img_url' => base_url('files/captcha').'/',
            'font_path' => BASEPATH.'fonts/texb.ttf',
            'img_width' => 150,
            'img_height' => 45,
            'expiration' => 7200
        );

        $cap = create_captcha($vals);
        $data['captcha'] = $cap['image'];

        if(isset($this->session->userdata['image']))
            if(file_exists(BASEPATH."../files/captcha/".$this->session->userdata['image']))
                unlink(BASEPATH."../files/captcha/".$this->session->userdata['image']);

        $this->session->set_userdata(array(
            'captcha' => $captcha,
            'image' => $cap['time'].'.jpg'
        ));

        $data['categories'] = $this->get_categories();
        $post = new Post();
        $post = $post->where('slug', $slug)->get();

        if(empty($post) || is_null($slug)){
            show_404();
        }

        $data['post'] = $post;
        $data['comments'] = $this->get_comments($post->id);
        $data['pub_user'] = $this->user->get_by_id($post->user_id);

        $this->load->view('frontend/post', $data);
    }

    public function get_categories()
    {
        $categories = new Category();
        return $categories->get();
    }

    public function get_comments($post_id)
    {
        $comments = new Comment($post_id);
        return $comments->where('post_id',$post_id)->get();
    }

    public function feed($id = null){
        header("Content-Type: text/xml;charset=utf-8");

        $category = new Category($id);
        $data['category'] = $category;

        $data['feed_name'] = 'BuilderEngine';
        $data['encoding'] = 'utf-8';
        $data['feed_url'] = current_url();
        $data['page_description'] = 'Free Website Builder for creating your own websites and blogs. Easy To Use and Powerful, build websites: Social Networks, eCommerce, Classifieds, Bookings, Portfolios, Galleries, Auctions, Events, & more. No coding skills needed.';
        $data['page_language'] = 'en-en';

        $data['posts'] = $category->post->order_by('time_created', 'desc')->get_paged(1, 6);

        $this->load->view('frontend/feed', $data);die;
    }

    public function deleteComment(){
        if(!$this->user->is_member_of("Administrators"))
            show_404();

        if($this->input->post('comment_id')){
            $id = $this->input->post('comment_id', true);
            $id = intval($id);

            $comment = new Comment($id);
			$comment_reports = new Comment_report();
			foreach($comment_reports->where('comment_id',$id)->get() as $comment_report){
				$comment_report->delete();
			}
            $comment->delete_comment($id);
            redirect($_SERVER['HTTP_REFERER']);
        } else{
            show_404();
        }
    }
    public function delete_report($id)
    {
        $comment_report = new Comment_report($id);
        $comment_report->delete();
        redirect(base_url('/admin/module/blog/show_objects/comment_report'), 'location');
    }
    private function validate_comment(){
        $this->form_validation->set_error_delimiters('<p><strong class="text-danger">', '</strong></p>');
        if($this->user->is_guest()){
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        }

        if($this->BuilderEngine->get_option('be_blog_captcha') == 'yes'){
            $this->form_validation->set_rules('captcha', 'captcha', 'trim|required|validate_captcha');
        }

        $this->form_validation->set_rules('text', 'Comment', 'trim|required|xss_clean');
        $this->form_validation->set_rules('post_id', 'post_id', 'trim|required|is_natural_no_zero|xss_clean');

        return $this->form_validation->run();
    }

   

}