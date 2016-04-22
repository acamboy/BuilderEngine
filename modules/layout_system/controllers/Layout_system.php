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
	class Layout_system extends Module_Controller {
		public function index()
		{
			echo "Layout_system::index()";
		}
		public function test()
		{
			echo "Yep working wtf";
		}
		public function query1($string)
		{
			echo "Layout_system::query()"; 
		}

		public function editor_nav()
		{
			$this->show->disable_full_wrapper();

			$data['page_path'] = $_REQUEST['page_path'];
			$this->BuilderEngine->set_page_path($data['page_path']);
			$this->load->view('editor_nav');
		}
		public function erase_all_blocks()
		{
			$this->db->query('truncate be_blocks');
			$this->db->query('truncate be_block_relations');
			$this->db->query('truncate be_page_versions');
			redirect(base_url('/'), 'location');  
		}
		public function erase_page_blocks()
		{
			$page_path = $_GET['page_path'];
			$this->db->where('path', $page_path);
			$this->db->delete('be_page_versions');
			//redirect(base_url('/'), 'location');  

		}
        // edit for blocks 2.0
        public function load_section_script($block_id, $page_path, $section_type, $block_name)
        {
			$data['section_type'] = $section_type;
			$data['quick_menu'] = $this->get_quick_menu('add_block', $block_id, $block_name);
			$data['block_id'] = $block_id;
			$data['page_path'] = $page_path;
			$data['block_name'] = $block_name;

            return $this->load->view('section_script', $data, true);
        }
        public function load_new_block_scripts($block_id, $html_parent_element, $page_path, $new_element_html, $block_name = 'unavailable', $quick_menu_type = 'style')
        {
            $this->BuilderEngine->set_page_path($page_path);
            $block = new Block('custom-block-'.$block_id);
            $block->load();
            $content = $block->data('content');
            if(is_array($content) && !empty($content))
            {
                end($content);
                $data['last_key'] = key($content);
            }
            else
                $data['last_key'] = 0;

            $data['block_id'] = $block_id;
			if (strpos($html_parent_element, 'generic-block') !== false) {
				$data['html_parent_element'] = '.'.$html_parent_element;
			}
			else if (strpos($html_parent_element, 'ordered-list') !== false) {
				$data['html_parent_element'] = '#'.$html_parent_element;
			}
			else if (strpos($html_parent_element, 'unordered-list') !== false) {
				$data['html_parent_element'] = '#'.$html_parent_element;
			}
			else
            	$data['html_parent_element'] = '#block-content-id-'.$block_name;
			$data['page_path'] = $page_path;
			$data['new_element_html'] = $new_element_html;
			$data['block_name'] = $block_name;
			$data['block_type'] = $block->type();
			$data['quick_menu'] = $this->get_quick_menu($quick_menu_type, $block_id, $block_name);

			return $block_scripts = $this->load->view('new_block_scripts', $data, true);
        }

		public function get_quick_menu($type, $block_id, $block_name)
		{
			$data['type'] = $type;
			$data['block_id'] = $block_id;
			$data['block_name'] = $block_name;

			return trim(preg_replace('/\s+/', ' ', $this->load->view('quick_menu', $data, true)));
		}
	}

?>