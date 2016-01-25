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


class Admin_main extends BE_Controller
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

    public function Admin_main()
    {
        parent::__construct();

        if ($this->uri->segment(3) != 'login' && $this->uri->segment(3) != 'recover_password' && $this->uri->segment(3) != 'approve_account' && $this->uri->segment(3) != 'logout') {

            $this->user->require_group("Administrators");
        } else if ($this->uri->segment(3) == 'login')
            if ($this->user->is_logged_in())
                redirect("/admin/main/dashboard", 'location');
    }

    public function dashboard()
    {
        $countries = $this->BuilderEngine->getcountries();
        $countriesArr = Array();
        $n = 0;
        foreach ($countries as $c) {
            $countriesArr[$n]['ip'] = $c->ip;
            $countriesArr[$n]['count'] = $c->count;
            $n++;
        }

        $countryFullNamesArr = Array();
        $arrCountries = array();
        $arr = array();
        $k = 0;
        foreach ($countriesArr as $ca) {

            $ip = $ca['ip'];
            $apiurl = 'http://ip-api.com/json/'.$ip;

            /* try this code for new fersion php */
            // $res = file_get_contents($apiurl);

            /* try this code for new fersion php */
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiurl);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            $res = curl_exec($ch);
            curl_close($ch);

            $res = json_decode($res);

            if(isset($res->status)
                && isset($res->country)
                && isset($res->countryCode)
                && $res->status == 'success'){

                $arr[$k][] = $res->country;
                $countryFullNamesArr[$k]['name'] = $res->country;
                $arrCountries[$res->countryCode] = '#00acac';

                $countOfVisits = $this->BuilderEngine->getVisitsByIp($ip);
                $countryFullNamesArr[$k]['count'] = $countOfVisits;
                $k++;
            }
        }

        /*Get's only unique countries*/
        $countryUnique = Array();
        foreach ($countryFullNamesArr as $val) {
            $countryUnique[] = $val['name'];
        }
        $countryUnique = array_unique($countryUnique);

        $j = 0;
        $arrCounts = Array();

        /*Sum up all countries by their visitors' count*/

        foreach ($countryFullNamesArr as $key => $val) {
            $sum = 0;
            foreach ($countryUnique as $c) {
                if ($val['name'] == $c) {
                    $sum += $val['count'];
                    if (!isset($arrCounts[$c])) {
                        $arrCounts[$c] = $sum;
                    } else {
                        $arrCounts[$c] += $sum;
                    }
                }
            }

            if (count($arrCounts) > 2) {
                break;
            }
            $j++;
        }

        $jsonCountries = json_encode($arrCountries);
        $data['countryNamesArr'] = $jsonCountries;
        $data['arrCounts'] = $arrCounts;

        $todayvisitorscount = $this->BuilderEngine->todayvisitorscount();
        $data['todayvisitorscount'] = $todayvisitorscount;

        $lastweekvisitorscount = $this->BuilderEngine->lastweekvisitorscount();
        $data['lastweekvisitorscount'] = $lastweekvisitorscount;

        $all_users_count = $this->BuilderEngine->getuserscount();
        $todays_users_count = $this->BuilderEngine->getuserscount(true);
        $data['all_users_count'] = $all_users_count;
        $data['todays_users_count'] = $todays_users_count;

        # return data

        $this->show->set_default_breadcrumb(0, "Dashboard", "");
        $current_version = $this->BuilderEngine->get_option('version');

        $remote_version = $this->cache->fetch("latest_be_version");

        if ($remote_version == null) {
            $remote_version = file_get_contents("http://update-server.builderengine.com/check.php?version=" . $current_version);
            $this->cache->insert("latest_be_version", $remote_version, 120);
        }

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
        $data['update_available'] = $this->check_cms_update();

        $data['statistics']['todays'] = $all_visits = $this->BuilderEngine->get_site_visits("all", 10, true);
        $data['statistics']['total_blogs'] = $this->BuilderEngine->getBlogCount();
        $data['statistics']['total_comments'] = $this->BuilderEngine->getBlogCommentsCount();

        $this->show->backend('dashboard', $data);
    }

    public function check_cms_update()
    {
        $updates = json_decode($this->update_check());

        if(isset($updates->result) && isset($updates->available_updates) 
            && ($updates->result && $updates->available_updates > 0)){
            $this->user->alert("Website Update is available.", "/admin/update/index", "i-download-4", "be-update");
            return true;
        }else{
            $this->load->model('alert');
            $this->alert->where(array('user_id' => $this->user->get_id(),'text' => 'Website Update is available.'))->get();
            $this->alert->delete();
            return false;
        }
    }

    public function login()
    {
        if (isset($_POST['forgot'])) {
            $this->users->send_password_reset_email(urldecode($_POST['email']));
        }
        $this->load->model("builderengine");
        $data['builderengine'] = &$this->builderengine;
		/*
        if($data['builderengine']->get_option('background_img'))
            $url = base_url($data['builderengine']->get_option('background_img'));
        else
		*/
		$url = get_theme_path()."assets/img/login-bg/bg-2.jpg";
        $data['url'] = $url;
        $data['login'] = true;
        $this->show->backend('index', $data);
    }

    public function approve_account($token = false)
    {
        $this->users->validate_registration_token($token);
        if (!$token) {
            redirect(base_url('/'), 'location');
        }
        $user = $this->users->activation_account($token);
        $this->user->initialize($user->id);
        redirect(base_url('/login'), 'location');
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
                redirect(base_url('/admin/main/login'), 'location');
            }
			else
				$data['error'] = true;
        }

        $this->load->model("builderengine");
        $data['builderengine'] = &$this->builderengine;
        $data['url'] = get_theme_path()."assets/img/login-bg/bg-2.jpg";
        $data['token'] = $token;
		$data['current_page'] = 'reset_password';
        $this->show->user_backend('reset_password',$data);
    }

    public function settings()
    {
        $this->show->set_default_breadcrumb(0, "Settings", "");
        $this->show->set_default_breadcrumb(1, "General", "");
        $this->load->model("builderengine");

        if ($_POST)
            foreach ($_POST as $key => $value) {
                $this->builderengine->set_option($key, $value);
            }

        $data['current_page'] = 'settings';
        $data['builderengine'] = &$this->builderengine;
		$data['erase_content_control'] = $this->builderengine->get_option('erase_content_control');
        $this->show->backend('settings', $data);
    }

    public function seo_settings()
    {
        $this->show->set_default_breadcrumb(0, "Settings", "");
        $this->show->set_default_breadcrumb(1, "Search Engine", "");
        $this->load->model("builderengine");

        if ($_POST) {
            $this->builderengine->set_option('google_analytics_code', $_POST['google_analytics_code']);
        }

        $data['current_page'] = 'settings';
        $data['builderengine'] = &$this->builderengine;
        $this->show->backend('seo_settings', $data);
    }

    public function search($keyword = '')
    {
        if ($_POST) {
            echo("<script>location.href = '<?=base_url('/admin/main/search')?>" . $_POST['keyword'] . "';</script>");
        }
        if (isset($keyword) && $keyword != '')
            $data['keyword'] = $keyword;
        else
            $data['keyword'] = '';
        $this->show->backend('search', $data);
    }

    public function logout()
    {
        $this->user->logout();
        redirect("/admin/main/login", 'location');
    }

    public function verify_login($user, $pass)
    {
        $user = $this->users->verify_admin_login($user, $pass);
        if ($user != 0) {
            $this->user->initialize($user);
            echo "success";
        } else
            echo "fail";
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

    function weather()
    {
        error_reporting(0);
        Header('Content-Type: text/html; charset=utf-8');

        $weather = $this->getWeather('Sofia'); // id нужного города
        file_put_contents('weather.png', file_get_contents($weather['img'])); // сохраним картинку погоды для вывода в качество иконки для notify-send.

        echo $weather['name'] . "\n";
        echo $weather['now']['temp'] . " °C\n";
        echo "Now: \n";
        echo "Clouds: " . $weather['clouds'] . "% \n";
        echo "Pressure: " . $weather['pressure'] . " hpa \n";
        echo "Humidity: " . $weather['humidity'] . "% \n";
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */