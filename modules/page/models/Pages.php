<?php
    class Pages extends CI_Model
    {
        function search($search = "")
        {
            if($search != ""){
                $query = $this->db->query("SELECT *,MATCH (`title`) AGAINST ('*$search*' IN BOOLEAN MODE) as score_title, MATCH (`content`) AGAINST ('$search') as score_content FROM (`be_posts`) WHERE MATCH (`title`) AGAINST ('*$search*' IN BOOLEAN MODE) OR MATCH (`content`) AGAINST ('$search') ORDER BY ((score_title*2)+score_content) DESC");
            }else{
                $this->db->order_by("date_created DESC");
                $query = $this->db->get("pages");
            }

            return $query->result();
            }
        function get($id)
        {
            $this->db->where("id", mysql_real_escape_string($id));
            $query = $this->db->get("pages");
            $result = $query->result();
            return $result[0];
        }
        
        function get_by_slug($slug)
        {
            $this->db->where("slug", mysql_real_escape_string($slug));
            $query = $this->db->get("pages");
            $result = $query->result();
            if($result)
                return $result[0];
            else
                return null;
        }
        function add($post, $author)
        {
            if($post['add_to_nav'] == 'yes' && isset($post['link']) && $post['link'] != '')
            {
                $link_info = array(
                    "name" => $post['title'],
                    "target" => "/page-".$post['slug'].".html",
                    "parent" => $post['link'],
                    "groups"  => $post['groups'],
                    "order" => 1
                    );
                $this->create_page_link($link_info);
            }
            global $user;
            $data = array( 
                "title" => $post['title'],
                "template" => $post['template'],
                "date_created" => time(),
                "author" => $author, 
                "slug"  => $post['slug'],
                "groups"  => $post['groups'],
                "meta_desc"  => $post['meta_desc'],
				"meta_keywords"  => $post['meta_keywords'],
                "seo_index"  => (!isset($post['seo_index']))? 'index,':'noindex,',
				"seo_follow"  => (!isset($post['seo_follow']))? 'follow,':'nofollow,',
				"seo_snippet"  => (!isset($post['seo_snippet']))? '':'nosnippet,',
				"seo_archive"  => (!isset($post['seo_archive']))? '':'noarchive,',
				"seo_img_index"  => (!isset($post['seo_img_index']))? '':'noimageindex,',
				"seo_odp"  => (!isset($post['seo_odp']))? '':'noodp',
            );

            $this->db->insert("pages", $data);
        }
        function create_page_link($data)
        {
            $this->load->model('links');
            $this->links->add($data);
        }

        function edit_page_link($name,$contents)
        {
            $this->load->model('links');
            $data = array(
                "name" => $contents['title'],
                "target"  => $contents['slug'],
                "meta_desc"  => $contents['meta_desc'],
                "meta_keywords"  => $contents['meta_keywords'],
                "groups"  => $contents['groups'],
            );
            $this->links->edit_page($name,$data);
        }

        function edit($id, $contents)
        {
            $data = array( 
                "title" => $contents['title'],
                "slug"  => $contents['slug'],
                "groups"  => $contents['groups'],
                "meta_desc"  => $contents['meta_desc'],
                "meta_keywords"  => $contents['meta_keywords'],
                "seo_index"  => (!isset($contents['seo_index']))? 'index,':'noindex,',
				"seo_follow"  => (!isset($contents['seo_follow']))? 'follow,':'nofollow,',
				"seo_snippet"  => (!isset($contents['seo_snippet']))? '':'nosnippet,',
				"seo_archive"  => (!isset($contents['seo_archive']))? '':'noarchive,',
				"seo_img_index"  => (!isset($contents['seo_img_index']))? '':'noimageindex,',
				"seo_odp"  => (!isset($contents['seo_odp']))? '':'noodp',
            );
            $this->db->where('id', $id);
            $this->db->update('pages', $data);        
        }
        function delete($id)
        {
            $delete_item = $this->get($id);
            $name = $delete_item->title;
            $this->delete_link($name);
            $this->db->where('id', $id);
            $this->db->delete('pages');
        }
        function delete_link($name){
            $this->load->model('links');
            $this->db->where('name', $name);
            $this->db->delete('links');
        }
    }
?>
