<?php
	class Module_system extends Module_Controller
	{
		private $module = null;
		public function __construct(){
			parent::__construct();
			if(!$this->user->is_member_of("Administrators"))
				die();
		}
		public function upload()
		{
			if(!$this->BuilderEngine->is_public_version())
				die("Not supported for cloud users");

			$path = $this->do_upload("module_zip");


			$zip = new ZipArchive;
            if ($zip->open($path) === TRUE) {
            	$stat = $zip->statIndex( 0 ); 
            	$folder = basename( $stat['name'] );
                $zip->extractTo(APPPATH.'../modules');
                $zip->close();
                
                unlink($path);

            }
            $this->install($folder);
		}
		private function do_upload($file)
		{
			if(!is_dir("./files"))
				mkdir("./files");

			if(!is_dir("./files/upload"))
				mkdir("./files/upload");


			 $this->load->library('upload');
 
            // Check if there was a file uploaded - there are other ways to
            // check this such as checking the 'error' for the file - if error
            // is 0, you are good to code
 
            // Specify configuration for File
            $filename = time();
            $config['file_name'] = $filename.".zip";
            $config['upload_path'] = './files/upload/';
            $config['allowed_types'] = 'zip';
            $config['max_size'] = '111000';

            $config['overwrite']  = true;
 
            // Initialize config for File
            $this->upload->initialize($config);
 
            // Upload file
            if ($this->upload->do_upload($file))
            {
                $result = $this->upload->data();
                return "./files/upload/".$filename.".zip";
            }else
            {
             $error = array('error' => $this->upload->display_errors());
             die($error['error']);
            }
		}
		public function update($module_folder)
		{
			$this->load->module($module_folder."/setup");

			$this->module = new Module();
			$this->module->where('folder', $module_folder)->get();
			
			if(get_class($this->setup) != 'setup')
				return;

			$this->setup->module = null;
			$this->setup->module = &$this->module;
			if($this->setup->update() !== false)
			{
				if(is_dir("modules/{$this->module->folder}/install/files"))
					$this->recurse_copy("modules/{$this->module->folder}/install/files", '.');
				$this->cache->delete("f_populate_admin_links-modules");
			}
		}
		public function install($module_folder)
		{

			PC::install("Installing module.");
			$this->load->module($module_folder."/setup");

			$this->module = new Module();
			$this->module->where('folder', $module_folder)->get();
			
			if(get_class($this->setup) != 'setup' || $this->module->installed == 'yes'){
				return $this->finish();
			}
			$this->module->folder = $module_folder;
			$this->module->save();
			
			$this->setup->module = null;
			$this->setup->module = &$this->module;
			if($this->setup->install() !== false)
			{
				return $this->finish();
			}
		}

		private function finish()
		{
			if(is_dir("modules/{$this->module->folder}/install/files"))
				$this->recurse_copy("modules/{$this->module->folder}/install/files", '.');
			$groups = new Group();
			foreach($groups->get() as $group)
			{
				$permission = new Group_module_permission();
				$permission->module_id = $this->module->id;
				$permission->group_id = $group->id;
				$permission->access = "frontend";
				$permission->save();
			}
			$admin_group = $groups->get_by_name("Administrators");

			$permission = new Group_module_permission();
			$permission->module_id = $this->module->id;
			$permission->group_id = $admin_group->id;
			$permission->access = "backend";
			$permission->save();
			$this->module->installer_id = $this->user->id                                                                                                                                                            ;
			$this->module->installed = 'yes';
			$this->module->install_time = time();
			$this->module->save();
			$this->cache->delete("f_populate_admin_links-modules");

			

			sleep(1);
			redirect(url("admin/modules/show"));

		}
		private function recurse_copy($src,$dst) { 
		    $dir = opendir($src); 
		    @mkdir($dst); 
		    while(false !== ( $file = readdir($dir)) ) { 
		        if (( $file != '.' ) && ( $file != '..' )) { 
		            if ( is_dir($src . '/' . $file) ) { 
		                $this->recurse_copy($src . '/' . $file,$dst . '/' . $file); 
		            }
		            else
		            {
		                copy($src . '/' . $file,$dst . '/' . $file);
		            }
		        }
		    }
		    closedir($dir);
		} 
	}
?>