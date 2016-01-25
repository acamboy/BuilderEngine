<?php
class Options extends DataMapper 
{
    var $table = 'options';

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }
    public function get_option_by_name($name)
    {
        return $this->where('name',$name)->get();
    }
    public function update_option_by_name($name, $value)
    {
        $this->where('name',$name)->update('value',$value);
    }
}
?>