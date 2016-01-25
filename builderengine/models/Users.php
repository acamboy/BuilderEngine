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

    class Users extends CI_Model {
 
        function get_current_user()
        {
            global $active_show;
            return $active_show->controller->user;
        }
        function is_online($id) {
            $timeout = 300;
 
            $now = strtotime("now");
            $id = mysql_real_escape_string($id);
 
            $this->db->select('last_activity')->where("`id` = '".$id."'", "LIMIT 1", FALSE);
            $query = $this->db->get('users');
            $last_activity = $query->first_row()->last_activity;
 
            if($now - $last_activity < 300)
                return true;
            return false;
        }
        function validate_password_reset_token(&$token)
        {
            $this->db->where("pass_reset_token", $token);
            $query = $this->db->get("users");
            $result = $query->result();

            if(!$result)
                $token = FALSE;
        }
        function validate_registration_token(&$token)
        {
            $this->db->where("cache_token", $token);
            $query = $this->db->get("users");
            $result = $query->result();

            if(!$result)
                $token = FALSE;
        }
        function register_activity($id) {
            $now = strtotime("now");
            $id = mysql_real_escape_string($id);
 
            $object = array('last_activity' => $now);
            $this->db->where("`id` = '".$id."'", "LIMIT 1", FALSE);
            $this->db->update('users', $object);
        }
 
        function set_user_groups_by_name($user, $groups)
        {
            $groups = explode(",", $groups);
 
 
            $this->db->delete('link_groups_users', array('user_id' => $user));
 
            foreach($groups as $group)
            {
                $group_id = $this->get_group_id_by_name($group);
                if($group_id == -1)
                    continue;
 
                $data = array(
                    "user_id" => $user,
                    "group_id"=> $group_id
                );
                $this->db->insert("link_groups_users", $data);
            }
        }
        function get_group_id_by_name($name)
        {
            $this->db->where("name", $name);
            $query = $this->db->get("user_groups");
            $result = $query->result();
            if(count($result) != 0)
            {
                return $result[0]->id;
            }else
                return -1;
        }
 
        function register_user($data, $admin = false){
            if($this->username_already_used($data['username']) || $this->email_already_used($data['email'])){
                return 0;
            }
			$this->load->model("builderengine");
			
            $insert = array(
                'first_name'        => (isset($data['first_name'])) ? $data['first_name'] : '',
                'last_name'         => (isset($data['last_name'])) ? $data['last_name'] : '',
                'username'          => $data['username'],
                'password'          => md5($data['password']),
                'email'             => $data['email'],
                //'level'             => ($admin == true)?'Administrator':'Member',
                'date_registered'   => time()
            );
            if(isset($data['avatar']))
                $insert['avatar'] = $data['avatar'];
			else
				$insert['avatar'] = base_url().'builderengine/public/img/avatar.png';
            if(isset($data['verified']))
                $insert['verified'] = $data['verified'];

            $this->db->insert('users', $insert);
            $user = $this->db->insert_id();
			
            $user_data = $this->get_by_id($user);
            $username = $user_data->username;
            //$this->upload_avatar($username);
 
            if($admin)
                $data['groups'] = "Members, Administrators, Frontend Editor, Frontend Manager";
 
            if(!isset($data['groups']) || $data['groups'] == "")
                $data['groups'] = "Members";
			
			//if($this->builderengine->get_option('sign_up_verification') == 'email')
			//	$this->send_registration_email($data['email'],$user);
			if($this->builderengine->get_option('notify_admin_registered_user') == 'yes')
				$this->notify_admin();
				
            $this->set_user_groups_by_name($user,$data['groups']);
            return $user;
        }
        function delete_alerts_with_tag ($tag)
        {
            $this->db->where("tag", $tag);
            $this->db->delete("alerts");
        }
        function get_alerts($user) 
        {
            $this->db->where("user", $user);
            $query = $this->db->get("alerts");
            $result = $query->result();


            return $result;
        }
        function add_alert($user, $text, $url, $icon, $tag)
        {
            $this->db->where("user", $user);
            $this->db->where("text", $text);
            $this->db->where("url", $url);
            $query = $this->db->get("alerts");
            $result = $query->result();
            if($result)
            {
                return;
            }

            $data = array(
                "user"  => $user,
                "text"  => $text,
                "url"   => $url,
                "icon"  => $icon,
                "tag"   => $tag
                );

            $this->db->insert("alerts", $data);
        }
        function add_group($data)
        {
            if($this->group_already_used($data['group']))
                return 0;
 
            $data = array(
                'name'              => $data['group'],
                'description'       => $data['description'],
                'allow_posts'       => intval($data['posts']),
                'allow_categories'  => intval($data['categories']),
            );
 
            $this->db->insert('user_groups', $data);
            return $this->db->insert_id();
        }
 
        function edit_group($data)
        {
 
            $update = array(
                'name'                      => $data['group'],
                'description'               => $data['description'],
                'allow_posts'               => intval($data['posts']),
                'allow_categories'          => intval($data['categories']),
                'use_created_categories'    => intval($data['use_created_categories']),
                'default_user_post_category'=> $data['default_user_post_category'],
            );
 
            $this->db->where('id', $data['id']);
            $this->db->update('user_groups', $update);
        }
 
        function delete($id)
        {
            $this->db->delete('users', array('id' => $id));
        }
        function upload_avatar($username)
        {
            if(!is_dir("files"))
                mkdir("files");
 
            if(!is_dir("files/avatars"))
                mkdir("files/avatars");
 
 
            $this->load->library('upload');
 
            $file = 'avatar';
            // Check if there was a file uploaded - there are other ways to
            // check this such as checking the 'error' for the file - if error
            // is 0, you are good to code
 
 
            // Specify configuration for File
            $config['file_name'] = $username.".jpg";
            $config['upload_path'] = 'files/avatars/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '11100';
            $config['max_width']  = '22048';
            $config['max_height']  = '22048';
            $config['overwrite']  = true;
 
            // Initialize config for File
            $this->upload->initialize($config);
 
            // Upload file
            if ($this->upload->do_upload($file))
            {
                $result = $this->upload->data();
            }
 
     
        }
		function notify_admin()
		{
			$this->load->model("builderengine");
            $to = $this->builderengine->get_option("adminemail");
			$protocol = strtolower(substr($_SERVER['SERVER_PROTOCOL'],0,strrpos($_SERVER['SERVER_PROTOCOL'],'/'))).'://';
			$url = $_SERVER['SERVER_NAME'].substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],'index.php'));
			$site_url = $protocol.$url;
			$link = $site_url."admin/main/login";
			$subject = 'New User Registration !';
            $message = '<h2>New user has been registered!</h2><br/>Log in to '. $_SERVER['HTTP_HOST'].' to check out new account created <a href="'.$link.'">here</a>.';
            $headers = 'MIME-Version: 1.0' . "\r\n".
                'Content-type: text/html; charset=iso-8859-1' . "\r\n".
                'From: '.$this->builderengine->get_option("email_address") . "\r\n" .
                'Reply-To: '.$this->builderengine->get_option("email_address") . "\r\n" .
                'mailed-by: '.$this->builderengine->get_option("email_address") . "\r\n";

            mail($to, $subject, $message, $headers);		
		}
        function send_password_reset_email($email)
        {
            $token = md5(time().rand(0,99999999999999999999));
			$protocol = strtolower(substr($_SERVER['SERVER_PROTOCOL'],0,strrpos($_SERVER['SERVER_PROTOCOL'],'/'))).'://';
			$url = $_SERVER['SERVER_NAME'].substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],'index.php'));
			$site_url = $protocol.$url;
			if($email == $this->BuilderEngine->get_option('adminemail') && $this->BuilderEngine->get_option('user_dashboard_activ') == 'no')
				$link = $site_url."admin/main/recover_password/".$token;
			else
				$link = $site_url."user/main/recover_password/".$token;

            $to      = $email;
            $subject = 'Password Reset Token';
            $message = '<h2>Password Reset</h2><br>We have received a password reset request for your account at '. $_SERVER['HTTP_HOST'].'<br>To reset your password please click <a href="'.$link.'">HERE</a>.';
            $headers = 'MIME-Version: 1.0' . "\r\n".
                'Content-type: text/html; charset=iso-8859-1' . "\r\n".
                'From: no-reply@'.$_SERVER['HTTP_HOST'] . "\r\n" .
                'Reply-To: no-reply@'.$_SERVER['HTTP_HOST'] . "\r\n" .
                'mailed-by: no-reply@'.$_SERVER['HTTP_HOST'] . "\r\n";

            mail($to, $subject, $message, $headers);

            $update = array("pass_reset_token" => $token);
            $this->db->where("email", $email);
            $this->db->update("users", $update);
        }
        function send_registration_email($email,$id)
        {
            $this->load->model("builderengine");

            $token = md5(time().$id.rand(0,99999999999999999999));
			$protocol = strtolower(substr($_SERVER['SERVER_PROTOCOL'],0,strrpos($_SERVER['SERVER_PROTOCOL'],'/'))).'://';
			$url = $_SERVER['SERVER_NAME'].substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],'index.php'));
			$site_url = $protocol.$url;
            $link = $site_url."admin/main/approve_account/".$token;
            $to      = $email;
            $subject = 'Registration Token';
            $message = $this->builderengine->get_option('register_email') . $_SERVER['HTTP_HOST'].'.<br>To activate your account please click <a href="'.$link.'">HERE</a>.';
            $headers = 'MIME-Version: 1.0' . "\r\n".
                'Content-type: text/html; charset=iso-8859-1' . "\r\n".
                'From: '.$this->builderengine->get_option("email_address") . "\r\n" .
                'Reply-To: '.$this->builderengine->get_option("email_address") . "\r\n" .
                'mailed-by: '.$this->builderengine->get_option("email_address") . "\r\n";

            mail($to, $subject, $message, $headers);

            $update = array("cache_token" => $token);
            $this->db->where(array("email" => $email, 'id' => $id));
            $this->db->update("users", $update);
        }
        function send_email_massage($email,$option,$subject)
        {
            $this->load->model("builderengine");
            $to      = $email;
            $message = $this->builderengine->get_option($option). $_SERVER['HTTP_HOST'].'.';
            $headers = 'MIME-Version: 1.0' . "\r\n".
                'Content-type: text/html; charset=iso-8859-1' . "\r\n".
                'From: '.$this->builderengine->get_option("email_address") . "\r\n" .
                'Reply-To: '.$this->builderengine->get_option("email_address") . "\r\n" .
                'mailed-by: '.$this->builderengine->get_option("email_address") . "\r\n";

            mail($to, $subject, $message, $headers);
        }
        function reset_password($token, $password)
        {
            $update = array(
                "password"          => md5($password),
                "pass_reset_token"  => "");
            $this->db->where("pass_reset_token", $token);

            $this->db->update("users", $update);
        }
        function activation_account($token)
        {
            $user = $this->db->get_where('users',array("cache_token" => $token))->row();

            $this->send_email_massage($user->email,'verification_email','Verification');
            $this->send_email_massage($user->email,'welcome_email','Welcome');
            $update = array("verified"  => "yes","cache_token" => "");
            $this->db->where("cache_token", $token);
            $this->db->update("users", $update);

            return $user;
        }
        function edit($data){
            $update = array(
                'first_name'        => $data['first_name'],
                'last_name'         => $data['last_name'],
                'username'         => $data['username'],
                'email'             => $data['email'],
                'avatar'            => $data['avatar']
                //'level'             => $data['level'],
            );
 
            $user = $this->get_by_id($data['id']);
            $username = $user->username;
			if(empty($update['avatar']))
				$update['avatar'] = $user->avatar;
            $this->upload_avatar($username);
 
            if(strlen($data['password']) > 1)
                $update['password'] = md5($data['password']);
 
            $this->db->where('id', $data['id']);
            $this->db->update('users', $update);
 
            $this->set_user_groups_by_name($data['id'], $data['groups']);
            return true;
        }
 
        function get($search = "",$data = array())
        {
            $search = mysql_real_escape_string($search);
            if($search != "")
                $this->db->where("`username` like '%".$search."%'", NULL, FALSE);
            if(!empty($data))
                    $this->db->where($data);

            $this->db->limit(600);
            $query = $this->db->get("users");
            return $query->result();
        }

        public function user_verified($user_id, $status)
        {
            $data = array(
                'verified' => $status
                );
            $this->db->where('id', $user_id);
            $this->db->update('users', $data);
        }
 
        function get_group_by_id($id)
        {
            $id = mysql_real_escape_string($id);
            $this->db->where("`id` = '".$id."'", NULL, FALSE);
 
            $this->db->limit(1);
            $query = $this->db->get("user_groups");
            $result = $query->result();
            return $result[0];
        }
 
        function get_user_group_ids($user)
        {
            $id = mysql_real_escape_string($user);
            $this->db->where("`user_id` = '".$id."'", NULL, FALSE);
 
            $this->db->from("link_groups_users");
            $this->db->join('user_groups', 'user_groups.id = link_groups_users.group_id');
            $query = $this->db->get();
 
            $groups = array();
            foreach($query->result() as $group)
            {
                array_push($groups, intval($group->id));
            }
 
            return $groups;
        }
        function get_user_group_name($user)
        {
            $id = mysql_real_escape_string($user);
            $this->db->where("`user_id` = '".$id."'", NULL, FALSE);

            $this->db->from("link_groups_users");
            $this->db->join('user_groups', 'user_groups.id = link_groups_users.group_id');
            $query = $this->db->get();

            $groups = array();
            foreach($query->result() as $group)
            {
                array_push($groups,$group->name);
            }

            return $groups;
        }
        function get_groups($search = "")
        {
            $search = mysql_real_escape_string($search);
            if($search != "")
                $this->db->where("`name` like '%".$search."%'", NULL, FALSE);
 
            $this->db->limit(600);
            $query = $this->db->get("user_groups");
            return $query->result();
        }
        function get_group_name_by_id($group_id)
        {
 
            $this->db->where('id', $group_id);
            $query = $this->db->get("user_groups");
            $result = $query->result();
 
            return $result[0]->name;
        }
        function get_groups_string($user)
        {
            $this->db->where('user_id', $user);
            $query = $this->db->get("link_groups_users");
            $result = $query->result();
 
 
            $groups = array();
            foreach($result as $group)
            {
                $group_name = $this->get_group_name_by_id($group->group_id);
                array_push($groups, $group_name);
            }
 
            $result = implode(",", $groups);
 
            return $result;
        }
        function get_by_id($id)
        {
            $id = mysql_real_escape_string($id);
            $this->db->where("`id` = '".$id."'", "LIMIT 1", FALSE);
 
            $query = $this->db->get("users");
            $result = $query->result();

            if(!$result)
                return null;
            $result = $result[0];
 
            $obj = (object) array_merge( (array)$result, array( 'groups_string' => $this->get_groups_string($id) ) );
            return $obj;
        }
        function is_admin()
        {
            foreach ($this->get_user_group_ids(get_active_user_id()) as $key => $value) {
                if($this->get_group_by_id($value)->name == 'Administrators')
                    return true;
            }
            return false;
        }
        function is_admin_by_id($id)
        {
            foreach ($this->get_user_group_ids($id) as $key => $value) {
                if($this->get_group_by_id($value)->name == 'Administrators')
                    return true;
            }
            return false;
        }
        function email_already_used($email = ""){
            $email = mysql_real_escape_string($email);
 
            $this->db->where(array('email' => $email));
            $this->db->from("users");
 
            $count = $this->db->count_all_results();
            return $count != 0;
        }
 
        function username_already_used($username = ""){
            $username = mysql_real_escape_string($username);
 
            $this->db->where(array('username' => $username));
            $this->db->from("users");
 
            $count = $this->db->count_all_results();
            return $count != 0;
        }
 
        function group_already_used($username = ""){
            $username = mysql_real_escape_string($username);
 
            $this->db->where(array('name' => $username));
            $this->db->from("user_groups");
 
            $count = $this->db->count_all_results();
            return $count != 0;
        }
        function verify_login($username, $password, $admin = false){
			$this->load->model('builderengine');
			switch($this->builderengine->get_option('user_login_option'))
			{
				case 'username':
					$where = array(
						'username'  => $username,
						'password'  => md5($password),
						'verified'  => 'yes',
					);
					$this->db->where($where);
					break;
				case 'email':
					$where = array(
						'email'  => $username,
						'password'  => md5($password),
						'verified'  => 'yes',
					);
					$this->db->where($where);
					break;
				case 'both':
					$this->db->where("(email = '$username' OR username = '$username') 
					AND password = md5('$password') AND verified = 'yes'");
					break;
				case null:
					$where = array(
						'username'  => $username,
						'password'  => md5($password),
						'verified'  => 'yes',
					);
					$this->db->where($where);
			}
			
            $query = $this->db->get("users");
            $result = $query->result();
 
            if(count($result) != 1)
                return 0;
 
            $result = $result[0];
            return $result->id;
        }
 
        function verify_admin_login($username, $password)
        {
            return $this->verify_login($username, $password, true);
        }
 
    }
?>