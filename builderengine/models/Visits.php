<?php
class Visits extends DataMapper
{
    var $table = 'be_visits';

    var $has_many = array(
    	'post',
		'category'
	);

    function __construct($id = NULL)
    {
        parent::__construct($id);
    }

    public function populyar_post_by_visits()
    {
    	$post = new Post();
        $posts = $post->order_by('time_created','desc')->get();

        $res = $this->like('page','blog/post/','after')->get();
        
        $slugs = array();
        foreach ($res->all as $key => $value) {
        	$post = explode('/', $value->page);
        	if($post[1] == 'post')
        	{
        		if(array_key_exists($post[2], $slugs))
        		{
        			$slugs[$post[2]]++;
        		}else{
        			$slugs[$post[2]] = 1;
        		}
        	}
        }
    	foreach ($posts->all as $post_key => $post_value) {
    		if(!array_key_exists($post_value->slug, $slugs))
    			$slugs[$post_value->slug] = 0;
    	}
        arsort($slugs);
        return $slugs;
    }

    public function popular_category_by_visits()
    {
    	$category = new Category();
        $categories = $category->order_by('time_created','desc')->get();
        $res = $this->like('page','blog/category/','after')->get();
        
        $cats = array();
        foreach ($res->all as $key => $value) {
        	$category = explode('/', $value->page);
        	if($category[1] == 'category')
        	{
        		if(array_key_exists($category[2], $cats))
        		{
        			$cats[$category[2]]++;
        		}else{
        			$cats[$category[2]] = 1;
        		}
        	}
        }
    	foreach ($categories->all as $category_key => $category_value) {
    		if(!array_key_exists($category_value->id, $cats))
    			$cats[$category_value->id] = 0;
    	}
        arsort($cats);
        return $cats;
    }
}
?>