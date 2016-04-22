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
//

class Admin_ajax extends BE_Controller {

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
    
    public function Admin_ajax(){
        parent::__construct();

        $this->load->model('users');
        //$this->load->model('blocks');
        //$this->load->model('versions');
        $this->user = $this->users->get_current_user();
    }

    public function get_server_load()
    {
        $load = sys_getloadavg();
        $load = $load[0] * 100 / 4;
        echo (string)$load;
   
    }
    public function set_user_edit_mode($bool)
    {
        $this->user->editor_mode($bool == "true");
    }
    public function get_site_visitors()
    {
        echo $this->BuilderEngine->get_online_site_visitors();
    }
    public function test($block)
    {
        $latest_name = "Version (1)";

        $number = (int)preg_replace('/[^\-\d]*(\-?\d*).*/','$1',$latest_name);
        if($number > 0)
        {
            $old_number = $number;
            $number++;
            $new_name = str_replace($old_number, $number,$latest_name);
        }else
        {
            $new_name = str_replace($number, "",$latest_name);
            $new_name = trim($new_name, " ");
            $new_name .= " (1)";
        }

        echo $new_name;
        echo "Block active version: ".$this->blocks->get_active_version($block)."<br>";
        echo "Block pending version: ".$this->blocks->get_pending_version($block)."<br>";
    }
    
    public function copy_block($block_id = 0)
    {
        $copied_block = array(
            "block_id"  => $block_id,
            "version"   => $this->blocks->get_active_version($block_id)
            );

        //print_r( $this->user->get_session_data("copied_block"));
        $this->user->set_session_data("copied_block", $copied_block);
        
    }
    public function add_block()
    {
        $area_id = $_REQUEST['area'];
        $page = $_REQUEST['page_path'];

        echo $this->blocks->add($area_id, $page);
    }

    public function paste_block()
    {
        $copied_block = $this->user->get_session_data("copied_block");
        print_r($copied_block);
        if(!$copied_block){
            echo "No block";
            return;
        }
            
        $area_id = $_REQUEST['area'];
        $page = $_REQUEST['page_path'];

        $new_block = $this->blocks->add($area_id, $page);
        $this->blocks->copy($copied_block['block_id'], $copied_block['version'], $new_block, $this->blocks->get_pending_version($new_block), $area_id);
        $this->user->set_session_data("copied_block", false);
    }
    public function delete_block($id)
    {
        
        $this->blocks->delete($id);
    }
    public function save_block()
    {
        
        $id = $_REQUEST['id'];
        $style = (isset($_REQUEST['style'])) ? urldecode($_REQUEST['style']) : null;
        $classes = (isset($_REQUEST['classes'])) ? urldecode($_REQUEST['classes']) : null;
        $contents = (isset($_REQUEST['contents'])) ? urldecode($_REQUEST['contents']) : null;

        $this->blocks->save($id, $contents, $style, $classes);
    }
    public function get_user_avatar($username)
    {
        $user = new User();
        $user->get_by_username();
        echo $user->get_avatar();
    }
    public function verify_login()
    {
        $user = urldecode($_POST['user']);
        $pass = urldecode($_POST['pass']);

        $user = $this->users->verify_login($user, $pass);
        if($user != 0){
            $this->user->initialize($user);
            $this->user->notify('success', "Login successful!");
            echo "success";
        }else
            echo "fail";
    }
    public function registration()
    {
        if($this->input->post()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Second Name', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|alpha_numeric|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'Password', 'required|min_length[6]|alpha_numeric');

            if($this->form_validation->run()){
                $this->show->set_default_breadcrumb(0, "Settings", "");
                $this->show->set_default_breadcrumb(1, "General", "");
                $this->load->model('builderengine');

                if($this->builderengine->get_option('sign_up_verification') == 'admin')
                {
                    $this->load->model('options');
                    $_POST['groups'] = $this->options->get_option_by_name('default_registration_group')->value;
                    $new_user = $this->users->register_user($this->input->post());
                    echo 'register with admin';
                }elseif ($this->builderengine->get_option('sign_up_verification') == 'email') {
                    $this->load->model('options');
                    $_POST['groups'] = $this->options->get_option_by_name('default_registration_group')->value;
                    $new_user = $this->users->register_user($this->input->post());
                    $this->user->notify('success', "User created successfully!");
                    $this->users->send_registration_email($this->input->post('email'),$new_user);
                    echo 'register with email';
                }
            }else{
                $error['username'] = form_error('username');
                $error['email'] = form_error('email');
                $error['first_name'] = form_error('first_name');
                $error['last_name'] = form_error('last_name');
                $error['password'] = form_error('password');
                echo json_encode($error);
            }
        }
    }
    public function load_icon_selector(){
        $cssClassName = urldecode($_POST['base_class_name']);
        $html_tag = urldecode($_POST['html_tag']);
        $css_file = APPPATH."../".urldecode($_POST['css_file']);
        $data['target'] = $_POST['target'];

        $input = file_get_contents($css_file);

        preg_match_all('/([a-z0-9]*?\.?'.addcslashes($cssClassName, '-').'.*?)\s?\{/', $input, $matches);
        
        
        foreach($matches[1] as $key => &$class)
        {
            if(strpos($class, ":before") !== FALSE)
            {
                $class = substr($class,0,strpos($class, ":before"));
            }
            if($class[0] != "." || strpos($class, "+") !== FALSE || strpos($class, "[") !== FALSE || strpos($class, "\"" !== FALSE)){
                unset($matches[1][$key]);
                continue;
            }

            $matches[1][$key] = substr($class,1);
        }
        $icons = array_reverse($matches[1]);
        //print_r($matches[1]);
        $data['classes'] = $icons;
        $this->load->view("icon_selector", $data);

    }

    public function load_bg_selector(){

        $data['target'] = $_POST['target'];
        $this->load->view("bg_selector", $data);

    }

    public function load_block_editor() { ?>
        <div id="block-editor" style="position: relative; width: 640px;">
            <div class="block-editor"  style="width: 640px; position: absolute">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget second">
                            <div class="widget-title">
                                <div class="icon"><i class="icon20 i-menu-6"></i></div>
                                <h4>Block Editorjj</h4>
                                <a href="#" class="minimize"></a>
                            </div><!-- End .widget-title -->
                            <div class="widget-content">
                                <form class="form-horizontal">
                                    <div class="control-group">
                                        <div class="controls-row">
                                            <textarea id="text-editor" name="text-editor" class="span24" rows="4"></textarea>
                                        </div>
                                    </div><!-- End .control-group  -->
                                </form>
                                <button id="save-button" class="btn btn-primary">Save</button>
                                <button id="cancel-button" class="btn btn-primary">Cancel</button>
                            </div><!-- End .widget-content -->
                        </div><!-- End .widget -->
                    </div><!-- End .span6  -->
                </div>
            </div>
        </div>
<?php   }

    function load_versions_manager($mode){
        $page_path = urldecode($_POST['page_path']);

        if($mode == "page")
            $page_versions = $this->get_page_versions($page_path);
        else
            $page_versions = $this->get_page_versions("layout");
        foreach($page_versions as &$version)
        {

            if($version->author == 0)
                $version->author = "System";
            else
            {
                $author = $this->users->get_by_id($version->author);

                $version->author = ($author->name != "") ? $author->name : $author->username;
            }

            if($version->approver == 0)
                $version->approver = "System";
            else if($version->approver == -1)
            {
                $version->approver = "N/A";
            }else
            {
                $approver = $this->users->get_by_id($version->approver);
                $version->approver = ($approver->name != "") ? $approver->name : $approver->username;
            }
        }
        $data['mode'] = $mode;
        $data['page_versions'] = $page_versions;

        $this->load->view("versions_manager", $data);
    }
    

    public function publish_version()
    {
        //$this->db->query("LOCK TABLE be_blocks WRITE, be_page_versions WRITE, be_user_groups WRITE");
        $page_path = mysql_real_escape_string($_REQUEST['page']);
        $version_id = $this->versions->get_pending_page_version_id($page_path);
        if($version_id)
        {  
            $this->toggle_version_approved($version_id);
            $this->version_activate($version_id);
        }
        $page_path = "layout";
        $version_id = $this->versions->get_pending_page_version_id($page_path);
        if($version_id)
        {
            $this->toggle_version_approved($version_id);
            $this->version_activate($version_id);
        }

        //$this->db->query("UNLOCK TABLES");
    }
    function toggle_version_approved($id)
    {
        $this->load->model('versions');
        $this->versions = new Versions();
        $this->user->require_group("Frontend Manager");
        if($this->versions->is_version_approved($id))
            echo "Approved";
        else
            echo "Not Approved";
        ($this->versions->is_version_approved($id)) ? $this->versions->disapprove_version($id) : $this->versions->approve_version($id);
    }

    function version_activate($id)
    {
        $this->load->model('versions');
        $this->versions = new Versions();
        $this->user->require_group("Frontend Manager");
        $this->versions->activate_version($id);
    }
    function version_set_name()
    {
        $this->user->require_group("Frontend Manager");
        $version    = $_REQUEST['id'];
        $new_name   = urldecode($_REQUEST['new_name']);
        $this->versions->rename($version, $new_name);
    }
    function dashboard_get_date_before_now_visits($type, $days = 0)
    {
        $visits = $this->BuilderEngine->get_site_visits($type, $days, true);
        echo $visits;
    }
   
    public function validate_unique_field($table, $field, $original_value = ""){
        $table = mysql_real_escape_string(urldecode($table));
        $field = mysql_real_escape_string(urldecode($field));

        $original_value = urldecode($original_value);


        foreach($_POST as $post_value) // Hackfix, I know
        {
           $value = $post_value; 
        }
        $value = urldecode($value);
        $value = mysql_real_escape_string($value);

        $this->db->where(array($field => $value));
        $this->db->from($table);

        $count = $this->db->count_all_results();
        $exists = $count != 0;

        if($exists && $value != $original_value)
            echo "false";
        else
            echo "true";
    }

    function dashboard_get_visitors_graph($days)
    {
        $all_visits = $this->BuilderEngine->get_site_visits("all", $days, false);
        $unique_visits = $this->BuilderEngine->get_site_visits("unique", $days, false);

        $visits['all'] = json_encode( $all_visits);
        $visits['unique'] = json_encode( $unique_visits);
        echo json_encode($visits);
    }

    public function get_latest_news(){
        $curl = curl_init();

        curl_setopt_array($curl, Array(
            CURLOPT_URL            => 'http://builderengine.com/blog/feed/1',
            CURLOPT_USERAGENT      => 'spider',
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_ENCODING       => 'UTF-8'
        ));

        $data = curl_exec($curl);

        curl_close($curl);

        $xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
        $response = array();

        foreach ($xml->channel->item as $item) {
            $response[] = array(
                'title' => $item->title,
                'description' => $item->description,
                'link' => $item->link,
                'image' => $item->enclosure->attributes()->url
            );
        }

        echo json_encode($response);
    }

	public function send_email()
	{
		if($_POST){
			if($_POST['emailActive'] == 'yes'){
				$to = $_POST['emailDestination'];
				$subject = $_POST['emailTitle'];
				
				if($_POST['captchaActive'] == 'yes'){
					if($this->session->userdata('captcha'.$_POST['cap']) == $_POST['captcha']){
						unset($_POST['captchaActive']);
						unset($_POST['emailActive']);
						unset($_POST['cap']);
						unset($_POST['emailDestination']);
						unset($_POST['emailTitle']);
						unset($_POST['captcha']);
						
						$data['fields'] = $_POST;
						//$headers = "From: " . "\r\n";
						$headers = "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";					
						$message = $this->load->view('contact_form_block_email_template',$data,true);					
						mail($to,$subject,$message,$headers);
						//$this->session->unset_userdata('captcha'.$_POST['cap']);
						echo 'true';
					}else{
						echo 'false';
					}
				}
				else{
					unset($_POST['captchaActive']);
					unset($_POST['emailActive']);
					unset($_POST['cap']);
					unset($_POST['emailDestination']);
					unset($_POST['emailTitle']);
					unset($_POST['captcha']);

					$data['fields'] = $_POST;
					//$headers = "From: " . "\r\n";
					$headers = "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";					
					$message = $this->load->view('contact_form_block_email_template',$data,true);					
					mail($to,$subject,$message,$headers);
					//$this->session->unset_userdata('captcha'.$_POST['cap']);
					echo 'true';
				}
			}else{
				echo 'false';
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */