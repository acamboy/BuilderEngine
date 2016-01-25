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


class User_settings extends BE_Controller
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
    }

    public function edit_settings()
    {
        if(!$this->user->is_logged_in())
            redirect("/user/main/userLogin", 'location');
        else{
            $this->user->is_verified();
            $this->load->model('setting');
            if(isset($_POST['avatar'])){
                $this->setting->update_user_settings($this->user->get_id(),$_POST['avatar']);
                redirect(base_url("/user/main/dashboard"), "location");
            }
            $user_setting = $this->setting->get_user_settings($this->user->get_id())->all;
            if($user_setting)
                $data['avatar'] = intval($user_setting[0]->allow_avatar);
            else
                $data['avatar'] = 0;
            $this->show->set_user_backend();
            $this->show->user_backend('settings',$data);
        }
    }
}
/* End of file user_setting.php */
/* Location: ./application/controllers/user_setting.php */