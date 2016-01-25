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

if (!defined('BASEPATH')) exit('No direct script access allowed');


class User_main extends BE_Controller
{

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
    function __construct()
    {
        parent::__construct();

        $this->load->model('builderengine');
        if($this->builderengine->get_option('user_dashboard_activ') != 'yes')
            redirect("/", 'location');

        if($this->uri->segment(1) == 'login' && $this->uri->segment(2)){
            $module_id = $this->uri->segment(2);
            $this->load->model('module');
            $module = $this->module->get();

            foreach ($module->all as $key => $value) {
                if($value->id == $module_id){

                        /* first method */
                    if (file_exists(FCPATH.'modules/'.$value->folder.'/controllers/'.$value->folder.'.php') 
                        && method_exists($value->folder, 'login')
                        && is_callable(array($value->folder, 'login')))
                    {
                        redirect(base_url($value->folder.'/login'), 'location');
                    }

                        /* second method */
                    // switch ($value->folder) {
                    //     case 'page':
                    //         break;
                    //     case 'blog':
                    //         break;
                    //     case 'builderpayment':
                    //         break;
                    //     default:
                    //        redirect(base_url($value->folder.'/login'), 'location');
                    // }
                }
            }
        }

        if ($this->uri->segment(1) == 'login' /*&& $this->uri->segment(3) != 'recover_password' && $this->uri->segment(3) != 'logout'*/) {
            if($this->user->is_logged_in())
                redirect("/user/main/dashboard", 'location');
            else
                redirect("/user/main/userLogin", 'location');
        }
    }
    public function dashboard()
    {
        if(!$this->user->is_logged_in())
            redirect("/user/main/userLogin", 'location');
        else{
            $this->user->is_verified();
            $location_cache_id = "be_visitor_location_" . $_SERVER['REMOTE_ADDR'];
            $location = $this->cache->fetch($location_cache_id);
            if ($location == null) {
                $location = $this->getLocation($_SERVER['REMOTE_ADDR']);
                $this->cache->insert($location_cache_id, $location, 2678400);
            }

            $weather_cache_id = "be_admin_weather_forecast_" . md5(serialize($location));
            $weather = $this->cache->fetch($weather_cache_id);
            if ($weather == null && $weather = $this->getWeather($location)) {
                $this->cache->insert($weather_cache_id, $weather, 3600);
            }
            $data['weather'] = $weather;
            $this->show->set_user_backend();
            $this->show->user_backend('dashboard',$data);
        }
    }
    function getLocation($ip)
    {
        $url = "http://ip-api.com/json/" . $ip;
        $json = file_get_contents($url);

        $ip_data = json_decode($json, true);
        return $ip_data;
    }
    function getWeather($id)
    {
         if(!empty($id) && !empty($id['city']))
         {
             $current_weather = $this->getCurrentWeather($id['city'].",".$id['countryCode']);
             $result['location'] = $id['city'].", ".$id['country'];
             $result['now']['temp'] = round($current_weather['main']['temp']);
             $result['now']['code'] = $current_weather['weather'][0]['icon'];
             $result['now']['icon_class'] = $this->getWeatherIconClass($result['now']['code']);

             $url = 'http://api.openweathermap.org/data/2.5/forecast/daily?q='.$id['city'].",".$id['countryCode'].'&mode=json&units=metric&cnt=7';

             $json = @file_get_contents($url);

             $weatherData = json_decode($json, true);

             for($i = 1; $i < 7; $i++){
                 $result[$i]['time'] = $weatherData['list'][$i]['dt'];
                 $result[$i]['temp']['min'] = ceil($weatherData['list'][$i]['temp']['min']);
                 $result[$i]['temp']['max'] = floor($weatherData['list'][$i]['temp']['max']);
                 $result[$i]['code'] = $weatherData['list'][$i]['weather'][0]['icon'];
                 $result[$i]['icon_class'] = $this->getWeatherIconClass($result[$i]['code']);

             }

             //$result['now']['type'] = $weatherData['list'][0]
             return $result;
         }
    }
    function getCurrentWeather($city)
    {
        $url = "http://api.openweathermap.org/data/2.5/weather?q=$city&mode=json&units=metric";
        $json = @file_get_contents($url);
        $weatherData = json_decode($json, true);
        return $weatherData;
    }
    function getWeatherIconClass($weather)
    {
        switch (substr($weather, 0, 2)) {
            case "01":
                if ($weather == "01d")
                    return "i-sun-2 orange";
                else
                    return "i-moon ";
                break;
            case "02":
                return "i-cloud";
                break;

            case "03":
                return "i-cloud-2 dark";
                break;

            case "04":
                return "i-cloud-2 dark";
                break;

            case "09":
                return "i-weather-rain dark";
                break;

            case "10":
                return "i-weather-rain blue";
                break;
            case "11":
                return "i-weather-lightning red-smooth";
                break;

            case "13":
                return "i-weather-snow blue";
                break;


            default:
                return "";
                break;
        }
    }
    public function userLogin()
    {
        if (isset($_POST['forgot'])) {
            $this->users->send_password_reset_email(urldecode($_POST['email']));
        }
        $this->load->model("builderengine");
        $data['builderengine'] = &$this->builderengine;
        if($data['builderengine']->get_option('background_img'))
            $url = $data['builderengine']->get_option('background_img');
        else
            $url = get_theme_path()."assets/img/login-bg/bg-2.jpg";
        $data['url'] = $url;
        $this->show->set_user_backend();
        $this->show->user_backend('index',$data);
    }
    public function logout()
    {
        $this->user->logout("/user/main/userLogin");
        redirect("/user/main/userLogin", 'location');
    }
    public function  verify_login($user,$pass)
    {
        $user = $this->users->verify_admin_login($user, $pass);
        if ($user != 0) {
            if($this->user->verified == 'yes'){
                $this->user->initialize($user);
                echo "success";
            }else
                echo "not approved";
        } else
            echo "fail"; 
    }
    public function recover_password($token = FALSE)
    {

        $this->users->validate_password_reset_token($token);
        if (!$token)
		{
            redirect(base_url('/'), 'location');
        }
		
        $data['error'] = false;
		
        if ($_POST && $token)
		{
            if ($_POST['password'] == $_POST['password_re'])
			{
                $this->users->reset_password($token, $_POST['password']);
                redirect(base_url('/user/main/userLogin'), 'location');
            }
			else
				$data['error'] = true;
        }

        $this->load->model("builderengine");
        $data['builderengine'] = &$this->builderengine;
        if($data['builderengine']->get_option('background_img'))
            $url = base_url($data['builderengine']->get_option('background_img'));
        else
            $url = get_theme_path()."assets/img/login-bg/bg-2.jpg";

        $data['url'] = $url;
        $data['token'] = $token;
        $this->show->set_user_backend();
        $this->show->user_backend('reset_password',$data);
    }
    public function edit($user_id)
    {
        if(!$this->user->is_logged_in() || $this->session->userdata('user_id') != $user_id)
            redirect("/user/main/userLogin", 'location');

		$this->load->helper('form');
		$this->user->is_verified();
		$this->show->set_user_backend();
		$this->load->model('users');

		if($_POST)
		{
			if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['name']) )
			{
				$file_name = $_FILES['avatar']['name'];
				$file_size =$_FILES['avatar']['size'];
				$file_tmp = $_FILES['avatar']['tmp_name'];
				$file_type = $_FILES['avatar']['type'];   
				$file_ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
				$extensions = array("jpeg","jpg","png"); 
				
				if(!is_dir("files"))
					mkdir("files");
	 
				if(!is_dir("files/avatars"))
					mkdir("files/avatars");
					
				move_uploaded_file($file_tmp,"files/avatars/".$file_name);
			
				$_POST['avatar'] = base_url().'files/avatars/'.$file_name;
				unset($_FILES['avatar']);
			}
			elseif(isset($_POST['avatar1']))
			{
				$_POST['avatar'] = $_POST['avatar1'];
			}
			else
				$_POST['avatar'] = $this->user->avatar;
			$this->load->model('user');
			$groups = array();
			$groups_id = $this->user->groups;
			foreach ($groups_id as $key => $value) {
				array_push($groups, $this->users->get_group_name_by_id($value));
			}
			$_POST['groups'] = implode(",", $groups);
			$this->users->edit($_POST);
			$this->user->notify('success', "User edited successfully!");
			header( "refresh:1;url=".base_url()."user/main/dashboard");
		}

		$data['user_data'] = $this->users->get_by_id($user_id);
		$data['groups'] = $this->users->get_groups();
		$data['current_page'] = 'users';
		$this->show->user_backend('edit_user', $data);
    }
    public function groups()
    {
        if(!$this->user->is_logged_in())
            redirect("/user/main/userLogin", 'location');
        else{
            $this->user->is_verified();
            $groups = array();
            $user_groups_id = $this->users->get_user_group_ids($this->user->get_id());
            foreach ($user_groups_id as $key => $value) {
                array_push($groups, $this->users->get_group_by_id($value));
            }

            $data['groups'] = $groups;
            $data['current_page'] = 'groups';
            
            $this->show->set_user_backend();
            $this->show->user_backend('groups',$data);
        }  
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */