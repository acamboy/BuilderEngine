<?php
class Setting extends DataMapper 
{
    var $table = 'user_settings';

    var $has_one = array(
    	'user'
	);

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
    public function get_user_settings($user_id)
    {
		return $this->where('user_id',$user_id)->get();
    }
    public function update_user_settings($user_id, $data)
    {
        if($this->get_user_settings($user_id))
        {
            $this->user_id = $user_id;
            $this->allow_avatar = $data;
            $this->save();
        }else{
            $this->where('user_id',$user_id)->update('allow_avatar',$data);
            $this->update('allow_avatar',$data);
        }
    }
}
?>