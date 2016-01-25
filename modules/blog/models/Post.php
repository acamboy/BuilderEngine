<?php
    class Post extends DataMapper 
    {
        var $table = 'be_blog_posts';

        var $has_many = array(
            'comment'
        );
        var $has_one = array(
            'category'
        );

        public function create($data)
        {
            $data = array_map('mysql_real_escape_string', $data);
            $text = ChEditorfix($data['text']);
            $this->title = $data['title'];
            $this->text = $text;
            $this->image = $data['image'];
            $this->category_id = $data['category_id'];
            $this->comments_allowed = $data['comments_allowed'];
            $this->tags = $data['tags'];
            $this->groups_allowed = $data['groups_allowed'];
            $this->time_created = time();
            $this->slug = $data['slug'];
            $this->user_id = $data['user_id'];
            $this->save();
        }

        public function create_comment($data)
        {
            $comment = new Comment();
            $comment->name = $data['name'];
            $comment->text = $data['text'];
            $comment->time_created = time();
            $comment->save();
            $this->save_comment($comment);
        }

        public function save_in_category($category_id)
        {
            $category = new Category($category_id);
            $this->save_category($category);
        }
    }
?>