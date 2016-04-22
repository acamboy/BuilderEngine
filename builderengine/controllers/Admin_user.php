<?php
/***********************************************************
* BuilderEngine v3.1.0
* ---------------------------------
* BuilderEngine CMS Platform - Radian Enterprise Systems Limited
* Copyright Radian Enterprise Systems Limited 2012-2015. All Rights Reserved.
*
* http://www.builderengine.com
* Email: info@builderengine.com
* Time: 2015-08-31 | File version: 3.1.0
*
***********************************************************/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Admin_user extends BE_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -  
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function login()
    {
        $this->load->model('users');

        $this->show('index');    
        
    }
    public function search(){
        $this->user->require_group("Administrators");
        $this->load->model('users');
        
        $data = array();
        
        
        if($_POST)
            $data['search_results'] = $this->users->get($_POST['search']);
        else
            $data['search_results'] = $this->users->get();  
        
        $data['current_page'] = 'users';
        $this->show->backend('search_user', $data);    
    }
    public function groups(){
        $this->user->require_group("Administrators");
        $this->load->model('users');
        

        $data['groups'] = $this->users->get_groups();  
        $data['current_page'] = 'groups';
                  
        $this->show->backend('groups', $data);    
    }
    public function add()
    {
        $this->user->require_group("Administrators");
        $this->load->model('users');

        if($_POST)
        {
			if(empty($_POST['groups']))
				$_POST['groups'] = 'Members';
			if(empty($_POST['avatar']))
				$_POST['avatar'] = base_url().'builderengine/public/img/avatar.png';
			
            $_POST['verified'] = 'yes';
            $new_user = $this->users->register_user($_POST);
			
			if($new_user == 0)
			{
				$this->user->notify('error', "Username or email already taken !");
				//header( "refresh:1;url=".base_url()."admin/user/add");
				redirect(base_url().'admin/user/add');
			}
			else
			{
				$this->user->notify('success', "User created successfully!");
				//header( "refresh:1;url=".base_url()."admin/user/search");
				redirect(base_url().'admin/user/search');
			}
        }
        $data['groups'] = $this->users->get_groups(); 
        $data['current_page'] = 'users';
        $this->show->backend('add_user', $data); 
    }
    
    public function add_group()
    {
        $this->user->require_group("Administrators");
        $this->load->model('users');

        if($_POST){
            $new_user = $this->users->add_group($_POST);
            $this->user->notify('success', "Group created successfully!");
            header( "refresh:1;url=".base_url()."admin/user/groups");
        }

        $data['current_page'] = 'groups';
        $this->show->backend('add_group', $data); 
    }
    
    public function edit_group($id)
    {
        $this->user->require_group("Administrators");
        $this->load->model('users');
        $this->load->model('options');

        if($_POST)
        {
            if(isset($_POST['default_group']) && intval($_POST['default_group']))
                $this->options->update_option_by_name('default_registration_group',$_POST['group']);
            $new_user = $this->users->edit_group($_POST);
            $this->user->notify('success', "Group edited successfully!");
            redirect(base_url().'admin/user/groups','location');
        }
        
        $data['current_page'] = 'groups';
        $data['group'] = $this->users->get_group_by_id($id);
        $data['default_group'] = $this->options->get_option_by_name('default_registration_group')->value == $data['group']->name;

        $this->show->backend('edit_group', $data); 
    }
    public function delete_group($id)
    {
        $this->user->require_group("Administrators");
		$this->load->model('users');
		$this->db->where('group_id', $id);
		$this->db->delete('link_groups_users');
		
		$member_group = $this->users->get_group_id_by_name('Members');
		$users = new User();
		foreach($users->get() as $user)
		{
			$user_groups = $this->users->get_user_group_ids($user->id);
			if(empty($user_groups))
			{
                $data = array(
                    "user_id" => $user->id,
                    "group_id"=> $member_group,
                );
                $this->db->insert("link_groups_users", $data);				
			}
		}

		$this->load->model('pages');
		$pages = $this->db->get('pages');
		foreach($pages->result() as $page){
			$page_groups = explode(',',$page->groups);
			$group_to_delete = $this->users->get_group_by_id($id);
			$groups = '';
			foreach($page_groups as $page_group){
				if($page_group == $group_to_delete->name)
					unset($page_group);
				else
					$groups .= $page_group.',';
			}
			$groups = rtrim($groups,',');
			$update = array('groups' => $groups);
			$this->db->where('id',$page->id);
			$this->db->update('pages',$update);
		}
		
		$permission = new Group_permission();
		$permission = $permission->where('group_id',$id)->get();
		if($permission->group_id > 0)
			$permission->delete();
		
		$this->db->where('group_id',$id);
		$this->db->delete('link_permissions');
		
		$default_group = $this->BuilderEngine->get_option('default_registration_group');

		if($default_group == $group_to_delete->name)
			$this->BuilderEngine->set_option('default_registration_group','Members');
			
        $this->db->delete('user_groups', array('id' => $id));
		
		$default_website_access_groups = explode(',',$this->BuilderEngine->get_option('default_website_access_group'));
		$blog_access_groups = explode(',',$this->BuilderEngine->get_option('be_blog_access_groups'));
		$allgroups = new Group();
		$allgroups = $allgroups->get();
		$group_names = array();
		foreach($allgroups as $allgroup){
			array_push($group_names,$allgroup->name);
		}
		$result = array_diff($default_website_access_groups,$group_names);
		$result_blog = array_diff($blog_access_groups,$group_names);
		$dwag = str_replace($result,'',$this->BuilderEngine->get_option('default_website_access_group'));
		$this->BuilderEngine->set_option('default_website_access_group',$dwag);
		$bag = str_replace($result_blog,'',$this->BuilderEngine->get_option('be_blog_access_groups'));
		$this->BuilderEngine->set_option('be_blog_access_groups',$bag);

        redirect('/admin/user/groups/','location');
    }
    public function edit($user_id)
    { 
        $this->user->require_group("Administrators");
        $this->load->model('users');

        if($_POST)
        {
			if(empty($_POST['groups']))
				$_POST['groups'] = 'Members';
            $this->users->edit($_POST);			
            $this->user->notify('success', "User edited successfully!");
            //header( "refresh:1;url=".base_url()."admin/user/search");
			redirect(base_url().'admin/user/search');
        }
        $data['user_data'] = $this->users->get_by_id($user_id);
        $data['groups'] = $this->users->get_groups(); 
        $data['current_page'] = 'users';

        $this->show->backend('edit_user', $data); 
    }
    public function delete($user_id)
    {
        $this->user->require_group("Administrators");
        $this->load->model('users');

        $this->users->delete($user_id);
        $this->db->delete('link_groups_users', array('user_id' => $user_id));
        $this->load->helper('url');
        $this->user->notify('success', "User deleted successfully!");    
        redirect('/admin/user/search/', 'location');
    }
    public function validate_group($original_value = ""){
        $original_value = urldecode($original_value); 
        $group = $_POST['group'];
       $this->load->model('users');
       $group = urldecode($group);
       if($this->users->group_already_used($group) && $group != $original_value)
        echo "false";
       else
        echo "true";
    }
    public function email_exists($original_value = ""){ 
        $original_value = urldecode($original_value);
        $email = $_POST['email'];
       $this->load->model('users');
       $email = urldecode($email);
       if($this->users->email_already_used($email) && $email != $original_value)
        echo "true";
       else
        echo "false";
    }
    public function validate_email($original_value = ""){ 
        $original_value = urldecode($original_value);
        $email = $_POST['email'];
       $this->load->model('users');
       $email = urldecode($email);
       if($this->users->email_already_used($email) && $email != $original_value)
        echo "false";
       else
        echo "true";
    }

    public function register_email_settings()
    {
        $this->user->require_group("Administrators");
        $this->show->set_default_breadcrumb(0, "Settings", "");
        $this->show->set_default_breadcrumb(1, "General", "");
        $this->load->model("builderengine");

        if ($_POST)
            foreach ($_POST as $key => $value) {
                $this->builderengine->set_option($key, $value);
            }

        $data['current_page'] = 'users';
        $data['current_child_page'] = 'register';
        $data['builderengine'] = &$this->builderengine;
        $this->show->backend('register_email_settings', $data);
    }

    public function register_settings()
    {
        $this->user->require_group("Administrators");
        $this->show->set_default_breadcrumb(0, "Settings", "");
        $this->show->set_default_breadcrumb(1, "General", "");
        $this->load->model('builderengine');
        $this->load->model('users');
        $data['search_results'] = $this->users->get('',array('verified'=>'no'));
        $data['current_page'] = 'users';
        $data['current_child_page'] = 'register';
        if($this->builderengine->get_option('sign_up_verification') == 'admin')
        {
            $this->show->backend('register_settings', $data);
        }elseif ($this->builderengine->get_option('sign_up_verification') == 'email') {
            $this->show->backend('register_settings_email', $data);
        }
    }

    public function user_approve($user_id)
    {
        $this->user->require_group("Administrators");
        $this->load->model('users');
		$approved_user = $this->user->where('id',$user_id)->get();
		$this->users->send_email_massage($approved_user->email,'welcome_email','Welcome');
        $this->users->user_verified($user_id,'yes');
        $this->load->helper('url');
        $this->user->notify('success', "User approved successfully!");
        redirect('/admin/user/register_settings', 'location');
    }

    public function user_refuse($user_id)
    {
        $this->user->require_group("Administrators");
        $this->load->model('users');

        $this->users->user_verified($user_id,'ignored');
        $this->load->helper('url');
        $this->user->notify('success', "User refused successfully!");
        redirect('/admin/user/register_settings', 'location');
    }

    public function register_glogbal_settings()
    {
        $this->user->require_group("Administrators");
        $this->show->set_default_breadcrumb(0, "Settings", "");
        $this->show->set_default_breadcrumb(1, "General", "");
        $this->load->model('builderengine');

        if ($_POST)
            foreach ($_POST as $key => $value) {
                $this->builderengine->set_option($key, $value);
            }

        $data['current_page'] = 'users';
        $data['current_child_page'] = 'register';
        $data['sign_up_verification'] = $this->builderengine->get_option('sign_up_verification') == 'email';
        $data['user_dashboard_activ'] = $this->builderengine->get_option('user_dashboard_activ') != 'yes';
		$data['notify_admin_registered_user'] = $this->builderengine->get_option('notify_admin_registered_user') != 'yes';
        $this->show->backend('register_glogbal_settings', $data);
    }
    public function validate_username($original_value = ""){
        $original_value = urldecode($original_value);
        $username = $_POST['username'];
       $this->load->model('users');
       $username = urldecode($username);
       if($this->users->username_already_used($username) && $username != $original_value)
        echo "false";
       else
        echo "true";
    }
    public function user_dashboard_settings()
    {
        $this->user->require_group("Administrators");
        $this->show->set_default_breadcrumb(0, "Settings", "");
        $this->show->set_default_breadcrumb(1, "General", "");
        $this->load->model("builderengine");

        if ($_POST)
		{
            foreach ($_POST as $key => $value)
			{
                $this->builderengine->set_option($key, $value);
            }
		}

        $data['current_page'] = 'users';
        $data['builderengine'] = &$this->builderengine;
        $data['user_dashboard_activ'] = $this->builderengine->get_option('user_dashboard_activ') != 'yes';
        $data['user_dashboard_blog'] = $this->builderengine->get_option('user_dashboard_blog') != 'yes';
		//$data['user_dashboard_forum'] = $this->builderengine->get_option('user_dashboard_forum') != 'yes';
        $data['user_created_posts'] = $this->builderengine->get_option('user_created_posts') != 'yes';
		$data['user_login_option'] = $this->builderengine->get_option('user_login_option');
		$data['background_img'] = $this->builderengine->get_option('background_img');
		$data['logo_img'] = $this->builderengine->get_option('logo_img');
        $this->show->backend('user_dashboard_settings', $data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */