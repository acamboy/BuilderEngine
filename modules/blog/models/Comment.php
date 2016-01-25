<?php
	class Comment extends DataMapper 
	{
		var $table = 'blog_comments';

	    var $has_one = array(
        	'post'
    	);
        var $has_many = array(
            'comment_report'
        );

    	public function create($data)
    	{
            $data = array_map('mysql_real_escape_string', $data);
            
    		$this->post_id = $data['post_id'];
    		$this->user_id = $data['user_id'];			
    		$this->name = $data['name'];
    		$this->text = $data['text'];
    		$this->time_created = time();
    		$this->save();
    	}

        public function report($text = '')
        {
            $comment_report = new Comment_report();
            $comment_report->comment_id = $this->id;
            if($text != '')
                $comment_report->text = $text;
            $comment_report->time_of_creation = time();
            $comment_report->save();
        }

        public function delete_comment($id){
            $this->db
                ->where('id', $id)
                ->delete($this->table);
        }
	}
?>