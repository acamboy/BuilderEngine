<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
    public function __construct(){
        parent::__construct();

        $this->CI =& get_instance();
    }

	public function validate_captcha($captcha){
        if($this->CI->input->post('captcha') != $this->CI->session->userdata['captcha'])
        {
            $this->CI->form_validation->set_message('validate_captcha', 'Wrong captcha code.');
            return false;
        }else{
            return true;
        }
    }
}
/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */