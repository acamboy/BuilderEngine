<?php 	/***********************************************************
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

	class User extends DataMapper 
	{	
		/* DataMapper specific members below*/
		var $table = 'users';
		var $has_one = array();
		var $has_many = array(
            "alert",
            "group"	=> array(
				'join_table' => 'link_groups_users',
				'join_self_as' => 'user',
				'join_other_as' => 'group',
			), 
        );


		/* User specific members below*/

		private $session; 
		private static $s_session; 
        private $user_model;
        public $groups     = array();
        private $user_data;
        private $alerts;
        private $in_edit_mode;
        public $verified = '';

        public function __construct($id = NULL)
        {
           parent::__construct($id);
           EventManager::fire("builderengine_user_construct", $this);
           

        }
        function _init(&$session)
        {
            $in_edit_mode = false;
            $this->session = self::$s_session = &$session;  

            if($this->is_logged_in()){
                $this->initialize($this->get_id());
            }
            else
            {
                $this->ci_load->model('group');
            	$group = new Group();
                // $group =  $this->group;
            	$group->where('name', 'Guests')->get();
                array_push($this->groups, $group->id);
            }
        
        }

        function initialize($user_id)
        {
            $this->get_by_id($user_id);
        	foreach($this->group->get() as $group)
        	{
        		array_push($this->groups, $group->id);
        	}
            $this->session->set_userdata('user_id', (int)$user_id);
            $this->register_activity();
            $this->load_alerts();
        }
        public function get_group_ids()
        {
        	return $this->groups;
        }
        function load_alerts()
        {
        }
        function logout($redirect = "")
        {
            $this->session->sess_destroy();
            if($redirect != "")
                redirect($redirect, "location");
            else
                redirect(base_url("/admin/main/login"), "location");

        }
        function get_id()
        {
            return $this->session->userdata('user_id');   
        }
        function get_username()
        {
            return $this->username;    
        }
        function is_logged_in()
        {
            return $this->session->userdata('user_id') > 0;
        }
        
        function is_guest()
        {
            return $this->session->userdata('user_id') == 0;
        }
        function register_activity()
        {
        	$this->last_activity = time();
        	$this->save();
        }
        function is_member_of_any($groups)
        {

            foreach($groups as $entry)
            {
                if($this->is_member_of($entry))
                    return true;
            }
            
            return false;    
        }
        
        function is_member_of($group_id)
        {
            // TODO: check if other than current user is member of some group
            $int_val = intval($group_id);
            if(is_string($group_id)){
                $group = new Group();
                $group->where('name', $group_id)->get();
                $group_id = $group->id;
            }

            foreach($this->groups as $entry)
            {
                if($entry == $group_id)
                    return true;
            }
            
            return false;    
        }

        function require_group($group_name, $login_url = "/admin/main/login")
        {
             if($this->is_guest())
                redirect($login_url, 'location');

            $group = new Group();

            $group_id = $group->get_by_name($group_name)->id;
             
             if(!$this->is_member_of((int)$group_id)){ //PHP, why aren't you strong typed.......
                redirect('/', 'location');
                die();
            }
        }
        function is_verified()
        {
            if($this->get_id)
                if($this->verified == ''){
                    $user = $this->where('id',$this->get_id())->get();
                    $this->verified = $user->all->verified;
                }
            else
                redirect("/", 'location');
            if($this->verified != 'yes')
                redirect('/', 'location');
        }
        function require_login()
        {
            if($this->is_guest())
                redirect('/admin/main/login', 'location');
        }
        
        function notify($type, $message)
        {
            $notification = array(
                'type'      => $type,
                'message'   => $message
            );
            $notifications = array();
            array_push($notifications,$notification);
            $this->session->set_userdata('notifications', $notifications);
            return $this;
        }

        function editor_mode($bool)
        {
            $this->session->set_userdata('edit_mode', $bool);
            return $this;
        }
        function is_editor_mode()
        {
            return $this->session->userdata('edit_mode') == true;
        }
        function alert($text, $url, $icon, $tag)
        {
            // $alert = new Alert();
            $ci =& get_instance();
            $alert = $ci->load->model('alert');
            $alert->where("user_id", $this->id)->where("text", $text)->where("url", $url)->get();
            $alert->text = $text;
            $alert->url = $url;
            $alert->icon = $icon;
            $alert->tag = $tag;
            $alert->save();
            $this->save_alert($alert);
            //$this->user_model->add_alert($this->get_id(), $text, $url, $icon, $tag);
            $this->load_alerts();
            return $this;
        }
        function get_notifications()
        {
            $notifications = $this->session->userdata('notifications');
            $this->session->unset_userdata('notifications');
            if(is_array($notifications))
                return $notifications;
            else
                return array();
        }

        function get_alerts()
        {
            return $this->alerts;
        }

        function set_session_data($key, $value)
        {
            $this->session->set_userdata($key, $value);
            return $this;
        }

        function get_session_data($key)
        {
            return $this->session->userdata($key);
        }


        function can_access_module($module, $access_type)
        {
            
            foreach($this->groups as $user_group){
                foreach($module->group_permission->get() as $permission)
                {
                    if($user_group == $permission->group->get()->id && $permission->access == $access_type)
                        return true;
                }
            }
            return false;
        }

        function login($login, $password)
        {
            $this->group_start()->where('username', $login)->or_where('email', $login)->group_end()->where('password', md5($password))->get();

            if(!empty($this->id)){
                $this->initialize($this->id);
                $this->notify('success', "Login successful!");
                return true;
            }else
                return false;
        }

        function register()
        {
            $this->date_registered = time();
            $this->save();
            $this->groups = array();
            $this->set_member_of("Members");

            return $this;
        }

        function set_member_of($group_id)
        {
            $int_val = intval($group_id);
            if(is_string($group_id)){
                $group = new Group();
                $group->where('name', $group_id)->get();
                $this->save_group($group);
            }else
            {
                $group = new Group($group_id);
                $this->user->save_group($group);
            }

            return $this;
        }

        function get_avatar()
        {
            if($this->avatar == "")
                return base_url("/themes/dashboard/images/avatars/no_avatar.jpg");
            else
                return $this->avatar;
        }
        function upload_file($input_name, $url, $image_name)
        {
            $config['upload_path']          = $url;
            $config['file_type']            = 'image/jpeg';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['file_name']            = $image_name;
            $config['max_size']             = 1000000000;
            $config['max_width']            = 1024000000;
            $config['max_height']           = 76800000;

            $ci = & get_instance();
            $ci->load->library('upload', $config);

            $ci->upload->do_upload($input_name);
        }
	}
?>