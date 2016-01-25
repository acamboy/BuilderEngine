<?php
class Visits extends DataMapper
{
    var $table = 'be_visits';

    var $has_many = array(
    	'post'
	);

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }

    public function populyar_post_by_visits()
    {
    	$post = new Post();
        $posts = $post->order_by('time_created','desc');
        $posts = $posts->get();

        $res = $this->like('page','blog/post/','after')->get();
        
        $sluge = array();
        foreach ($res->all as $key => $value) {
        	$post = explode('/', $value->page);
        	if($post[1] == 'post')
        	{
        		if(array_key_exists($post[2], $sluge))
        		{
        			$sluge[$post[2]]++;
        		}else{
        			$sluge[$post[2]] = 1;
        		}
        	}
        }
    	foreach ($posts->all as $post_key => $post_value) {
    		if(!array_key_exists($post_value->slug, $sluge))
    			$sluge[$post_value->slug] = 0;
    	}
        arsort($sluge);
        return $sluge;
    }


}
?>