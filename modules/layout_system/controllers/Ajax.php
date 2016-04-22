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

	class Ajax extends Module_Controller {
		function initialize()
		{

		}
        public function toggle_option($block_name)
        {
            $page_path = $_POST['page_path'];

            $this->BuilderEngine->set_page_path($page_path);
            $block = new Block($block_name);
            $block->load();
            //echo json_encode(array( "Block type" => $block->type(), "Post" => $this->input->post() ));
            include_once("blocks/".$block->type()."/".$block->type().".php");

            $classname = $block->type()."_block_handler";
            $handler = new $classname();
            $handler->set_block($block);
            $handler->admin_option_toggle($_POST['data_toggle'], $_POST['data_toggle_state'] == 'true');
        }

        function get_block($block_name)
        {
            $page_path = $_POST['page_path'];
            PC::page_paths($page_path);
            $this->BuilderEngine->set_page_path($page_path);
            $this->versions->load_page_blocks();
            $block = new Block($block_name);
            $block->show();
        }

        public function select_option($block_name)
        {
            $page_path = $_POST['page_path'];

            $this->BuilderEngine->set_page_path($page_path);

            $block = new Block($block_name);
            $block->load();
            echo $block->type();
            include_once("blocks/".$block->type()."/".$block->type().".php");

            $classname = $block->type()."_block_handler";
            $handler = new $classname();
            $handler->set_block($block);
            print_r($_POST);
            return $handler->admin_option_select($_POST['data_option_name'], $_POST['data_option_choice']);
        }
		public function block_list_dropdown($parent)
		{
			$page_path = $_GET['page_path'];

        	$this->BuilderEngine->set_page_path($page_path);


			$parent = new Block($parent);
			$parent->load();

    		PC::debug("Setting page path to ".$page_path);
        	$data['blocks'] = get_blocks();
        	switch($parent->type())
        	{
        		case "column":
					$this->load->view('ajax/block_list_dropdown', $data);
					break;

				case "row":
					$this->load->view('ajax/row_block_list_dropdown', $data);
					break;
				case "content":
					$this->load->view('ajax/content_block_list_dropdown', $data);
					break;
				case "page":
					$this->load->view('ajax/page_block_list_dropdown', $data);
					break;
				case "header":
				case "footer":
					$this->load->view('ajax/header_block_list_dropdown', $data);
					break;

        	}
		}
		public function versions_window($mode)
		{
			$this->user->require_group("Frontend Manager");

	        $page_path = $mode.'/index';
	        if($mode == "page")
	            $page_versions = $this->versions->get_page_versions($page_path);
	        else
	            $page_versions = $this->versions->get_page_versions("layout");
	        foreach($page_versions as &$version)
	        {

	            if($version->author == 0)
	                $version->author = "System";
	            else
	            {
	                $author = $this->users->get_by_id($version->author);

                    $version->author = ( (property_exists($author, 'name')) && $author->name != "") ? $author->name : $author->username;
	            }

	            if($version->approver == 0)
	                $version->approver = "System";
	            else if($version->approver == -1)
	            {
	                $version->approver = "N/A";
	            }else
	            {
	                $approver = $this->users->get_by_id($version->approver);
	                $version->approver = ( (property_exists($approver, 'name')) && $approver->name != "") ? $approver->name : $approver->username;
	            }


	        }
	        $data['mode'] = $mode;
	        $data['page_versions'] = $page_versions;


	        $this->load->view("versions_manager", $data);
    	}
    	function admin_popup()
    	{
    		$this->load->view('admin_popup');
    	}

        function new_block_delete()
        {
			if($_POST)
			{
				$block_name = $_POST['blockName'];
				$key_to_delete = $_POST['keyToDelete'];
				$page_path = $_POST['pagePath'];

				$this->BuilderEngine->set_page_path($page_path);

				$block = new Block($block_name);
				$block->load();
				$old_content = $block->data('content');
				unset($old_content[$key_to_delete]);

				$block->set_data('content', $old_content, true);
				$block->save();

				return print_r($block->data('content'), true);
			}
        }

        function new_block_save()
        {
			if($_POST)
			{
				$block_name = $_POST['blockName'];
				$field_name = $_POST['fieldName'];
				$field_value = $_POST['fieldValue'];
				$page_path = $_POST['pagePath'];
				$is_array = $_POST['isArray'];
				$real_name = $_POST['realName'];

				if($is_array == true)
				{
					$block_name = urldecode($block_name);
					$field_name = urldecode($field_name);
					$field_value = urldecode($field_value);

					$field_info = explode('-', $field_name);

					$content = array();
					$content[$field_info[1]] = array();
					$content[$field_info[1]][$field_info[2]] = $field_value;

					$this->BuilderEngine->set_page_path($page_path);
					$block = new Block($real_name);
					$block->load();


					$old_content = $block->data('content');
					if(empty($old_content))
						$old_content[0] = array();

					foreach($old_content as $old_element)
					{
						$old_element = (object)$old_element;
					}

					$merged = array();
					foreach($content as $key_1 => $elem_1)
					{
						foreach($old_content as $key_2 => $elem_2)
						{
							if($key_1 == $key_2)
								$merged[$key_2] = array_merge($elem_2, $elem_1);
							else
								$merged[$key_1] = $elem_1;
						}
					}

					$result_array = array();
					foreach($old_content as $key_1 => $elem_1)
					{
						foreach($merged as $key_2 => $elem_2)
						{
							if($key_2 > max(array_keys($old_content)))
								$result_array[$key_2] = $elem_2;
						}
					}
					foreach($old_content as $key_1 => $elem_1)
					{
						foreach($merged as $key_2 => $elem_2)
						{
							if($key_1 == $key_2)
								$result_array[$key_1] = $elem_2;
							else
								$result_array[$key_1] = $elem_1;
						}
					}
					ksort($result_array);
					$objects_result_array = array();
					foreach($result_array as $key => $elem)
					{
						$objects_result_array[$key] = $this->convertToObject($elem);
					}
					$block->set_data('content', $objects_result_array, true);
					$block->save();
					$new_data = $block->data('content');

					return print_r($new_data, true);
				}
				else
				{
					$block_name = urldecode($block_name);
					$field_name = urldecode($field_name);
					$field_value = urldecode($field_value);

					$this->BuilderEngine->set_page_path($page_path);
					$block = new Block($block_name);
					$block->load();
					$block->set_data($field_name, $field_value, true);
					$block->save();
				}
			}
        }

        function convertToObject($array) {
            $object = new stdClass();
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $value = $this->convertToObject($value);
                }
                $object->$key = $value;
            }
            return $object;
        }

    	function block_admin($block_name, $menu = '', $menu_type = '')
    	{
    		$page_path = $_GET['page_path'];
    		PC::debug("Setting page path to ".$page_path);
        	$this->BuilderEngine->set_page_path($page_path);

    		$block = new Block($block_name);
    		if($menu == 'styler')
    			$window_name = 'Styling';
    		else
    			$window_name = 'Settings';
    		$block->load();
    		PC::debug($block, "ajax::block_admin");
    		if(isset($_POST['block_save']))
    		{
    			foreach($_POST as $key => $value)
    			{
    				$block->set_data($key, $value, true);
    			}
    			$block->save();
    		}
    		echo '
				<script src="'.base_url('/builderengine/public/js/jquery.js').'"></script>
				<link href="'.base_url('/themes/dashboard/assets/plugins/font-awesome-4.2.0/css/font-awesome.min.css').'" rel="stylesheet">
				<link href="'.base_url('/modules/layout_system/views/block_settings_popup_custom.css').'" rel="stylesheet" />
				<script src="'.base_url('/builderengine/public/js/bootstrap.js').'"></script> <!-- Bootstrap -->
    			<script>
    			var site_root = "'.home_url("").'";
    			$(document).ready(function () {
    				$("#block-admin-save").click(function (event){
    					$("#block-admin-save").html("Saving...");
    					$.ajax( {
					        url: site_root + "/index.php/layout_system/ajax/block_admin/'.$block_name.'?page_path='.$page_path.'",
					        async: false,
					        type: "post",
					        data: $("#block-admin-form").serialize(),
					    }).fail(function (data){alert(console.log(data))});
					    window.top.notifyChange();
						window.parent.reload_block(\''.$block_name.'\', window.parent.page_path, true);
						$("#admin-window").remove();

					event.preventDefault();

    				});
				});
    			</script>
				<script src="'.base_url('/themes/dashboard/assets/plugins/file_manager.js').'"></script>
    		';
    		echo '<div style="padding-left:25px; padding-right:25px">
    		<h4 style="margin-left: -17px !important;margin-bottom: 30px;color: #fff;"><i class="fa fa-cogs" style="color: #fff;font-size: 18px;padding-right: 6px;"></i>'.str_replace('_', ' ', ucfirst($block->type)).' '.$window_name.'</h4>


    		<form class="form-horizontal" id="block-admin-form" method="post">
    		<input type="hidden" name="block_save" name="">
    		<input type="hidden" name="page_path" value="'.$page_path.'">';
    		if($menu == 'styler')
    			$block->generate_admin('styler', $menu_type);
    		else
    			$block->generate_admin();
    		echo '

    			<div class=\"control-group\" style="float:right; margin-top:20px;margin-right: -15px;">
	            	<div class=\"controls controls-row\">
	            		<input id="block-admin-save" type="submit" class="btn btn-success" value="Save Changes">
            		</div>
            	</div>
	            		';
    		echo '</form></div>';
    	}

    	function block_styler($block_name)
    	{
    		//
    	}
    	function is_page_pending_submission()
    	{
    		$page_path = $_POST['page_path'];

    		$version_id = $this->versions->get_pending_page_version_id($page_path);
	        if($version_id)
	        	echo 'true';
	        else
	        	echo 'false';
    	}
    	function delete_version($id)
		{
		    $this->user->require_group("Frontend Manager");
		    $this->versions->delete($id);
		}
    	function version_set_name()
        {
            $this->user->require_group("Frontend Manager");
            $version    = $_REQUEST['id'];
            $new_name   = urldecode($_REQUEST['new_name']);
            $this->versions->rename($version, $new_name);
        }

        public function save_block_children()
	    {
	    	$this->BuilderEngine->set_page_path($_REQUEST['page_path']);

	        $name 		= $_REQUEST['name'];
	        //$page_path 	= mysql_real_escape_string($_REQUEST['page']);
	        $children 	= json_decode($_REQUEST['children']);
	        //$version_id = $this->versions->get_pending_page_version_id($page_path);
	        $block = new Block($name);
	        $block->load();
	        $block->remove_children();

	        foreach($children as $child_name)
	        {
	        	$child = new Block($child_name);
	        	$block->add_block($child);
	        }
	        $block->save();




	        //$this->db->query("UNLOCK TABLES");
	    }

        function save_block()
        {
        	PC::blabla($_POST['page_path']);
        	$page_path = $_POST['page_path'];
        	$this->BuilderEngine->set_page_path($page_path);
        	PC::Block("Saving block with page path". $this->BuilderEngine->get_page_path());
	        $name 		= $_REQUEST['name'];

	        $block = new Block($name);
	        $block->load();
	       // PC::Block($block);
	        $block->force_data_modification();

	        if(isset($_REQUEST['content']))
	       		$block->save_content($_REQUEST['content']);


			if(isset($_REQUEST['size'])){
				$block->remove_css_class($_REQUEST['initial_size']);
				$block->add_css_class($_REQUEST['size']);
	       		$block->set_css('min-height', $_REQUEST['height']);
	       	}
	       	//PC::Block($block);
	        $block->save();

        }

        function undo_block_free_mode()
        {
        	PC::blabla($_POST['page_path']);
        	$page_path = $_POST['page_path'];
        	$this->BuilderEngine->set_page_path($page_path);
        	PC::Block("Saving block with page path". $this->BuilderEngine->get_page_path());
	        $name 		= $_REQUEST['name'];

	        $block = new Block($name);
	        $block->load();
	       // PC::Block($block);
	        $block->force_data_modification();
	       	$block->set_css('left', '');
	       	$block->set_css('top', '');
			$block->set_css('width', '');
			$block->set_css('height', '');
	       	$block->set_css('z-index', '');
	       	// $block->set_css('position', 'absolute');
	        $block->save();
        }

        function save_block_free_mode()
        {
        	PC::blabla($_POST['page_path']);
        	$page_path = $_POST['page_path'];
        	$this->BuilderEngine->set_page_path($page_path);
        	PC::Block("Saving block with page path". $this->BuilderEngine->get_page_path());
	        $name 		= $_REQUEST['name'];

	        $block = new Block($name);
	        $block->load();
	       // PC::Block($block);
	        $block->force_data_modification();
	       	$block->set_css('left', $_REQUEST['left']);
	       	$block->set_css('top', $_REQUEST['top']);
			// $block->set_css('z-index', 'auto');
			$block->set_css('z-index', '9999');
			// $block->set_css('position', 'absolute');
	        $block->save();
        }

        function save_block_free_mode_risize()
        {
        	PC::blabla($_POST['page_path']);
        	$page_path = $_POST['page_path'];
        	$this->BuilderEngine->set_page_path($page_path);
        	PC::Block("Saving block with page path". $this->BuilderEngine->get_page_path());
	        $name 		= $_REQUEST['name'];

	        $block = new Block($name);
	        $block->load();
	       // PC::Block($block);
	        $block->force_data_modification();
	       	$block->set_css('width', $_REQUEST['width']);
	       	$block->set_css('height', $_REQUEST['height']);
	        $block->save();
        }

        public function publish_version()
	    {
	        //$this->db->query("LOCK TABLE be_blocks WRITE, be_page_versions WRITE, be_user_groups WRITE");
	        $page_path = mysql_real_escape_string($_REQUEST['page']);
	        $version_id = $this->versions->get_pending_page_version_id($page_path);
	        if($version_id)
	        {
	            $this->toggle_version_approved($version_id);
	            $this->version_activate($version_id);
	        }
	        $page_path = "layout";
	        $version_id = $this->versions->get_pending_page_version_id($page_path);
	        if($version_id)
	        {
	            $this->toggle_version_approved($version_id);
	            $this->version_activate($version_id);
	        }


	        //$this->db->query("UNLOCK TABLES");
	    }
	    function toggle_version_approved($id)
	    {
	        $this->user->require_group("Frontend Manager");
	        if($this->versions->is_version_approved($id))
	            echo "Approved";
	        else
	            echo "Not Approved";
	        ($this->versions->is_version_approved($id)) ? $this->versions->disapprove_version($id) : $this->versions->approve_version($id);
	    }

	    function version_activate($id)
	    {
	        $this->user->require_group("Frontend Manager");
	        $this->versions->activate_version($id);
	    }
	    function delete_block($name, $parent)
	    {
	    	echo $name;
	    	$page_path = $_GET['page_path'];
	    	PC::page_paths($page_path);
	    	$this->BuilderEngine->set_page_path($page_path);

	        $block = new Block($parent);
	        $block->load();

	        echo count($block->blocks);
	        $block->remove_child($name);

	        $block->save();

	    }
	    function test()
	    {
	    	print_r(scandir("."));
	    }

	    function add_block($parent, $type, $page_path = '')
	    {
            if($page_path == '')
	    	    $page_path = $_POST['page_path'];
            else
                $page_path = str_replace('_', '/', $page_path);
	    	PC::page_paths($page_path);
	    	$this->BuilderEngine->set_page_path($page_path);
	    	//$this->blocks->set_page_path($this->blocks->get_page_path_of($parent));
	    	$max_id = $this->blocks->get_max_block_id();

	    	$new_id = $max_id + 1;
	    	$new_block_name = "custom-block-".$new_id;

	    	$block = new Block($parent);
	        $block->load();
	        $new_block = new Block($new_block_name);
	        $new_block->set_type($type);
			$new_block->set_id($new_id);
	        if(isset($_POST['data_class']) && $_POST['data_class'] != "")
	        {
	        	$new_block->add_css_class($_POST['data_class']);
	        }
	        if($block->is_global())
	        	$new_block->set_global(true);
	        $block->add_block_first($new_block);
	        $block->save();

	        $new_block->set_content("Your new block.");

	        $new_block->show();

	    }

        public function get_blocks_for($block_type, $block_id, $block_name)
        {
			$data['block_type'] = $block_type;
			$data['block_name'] = $block_name;

			$block_info = explode('-', $block_name);
			if(strpos($block_name, 'custom-block') !== false)
				$data['block_id'] = $block_info[2];
			else
				$data['block_id'] = $block_id;
			$data['blocks'] = get_blocks();
            return $this->load->view('ajax/blocks_list', $data, true);
        }

		public function get_output_for($module, $object)
		{
			$this->load->module($module);
			$objects = new $object();
			$data['objects'] = $objects->get();
			return $this->load->view('ajax/module_output_sidebar', $data, true);
		}

		public function change_module_block_output($block_id, $newOutputObjectId, $page_path, $block_name)
		{
			$page_path = str_replace('_', '/', $page_path);
			$this->BuilderEngine->set_page_path($page_path);
			$block = new Block('custom-block-'.$block_id);
			$block->load();

			$custom_content = array();
			$custom_content['output'] = 'custom';
			$custom_content['outputId'] = $newOutputObjectId;

			$block->set_data('output', $custom_content, true);
			$block->save();

			$block = new Block($block_name);
			$block->load();
		}

		public function return_new_block_output($page_path, $block_name, $block_type = false)
		{
			$page_path = str_replace('_', '/', $page_path);
			$this->BuilderEngine->set_page_path($page_path);
			$block = new Block($block_name);
			$block->load();

			return $block->show();
		}
	}

?>