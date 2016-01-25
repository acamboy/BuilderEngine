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
	}

?>