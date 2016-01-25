<?php
	class Comment_report extends DataMapper 
	{
		var $table = 'blog_comment_reports';

	    var $has_one = array(
        	'comment'
    	);
	}
?>