<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
require_once( APPPATH . '/third_party/smarty/libs/SmartyBC.class.php' );

class MX_Loader extends CI_Loader
{
	protected $_module;
	
	public $_ci_plugins = array();
	public $_ci_cached_vars = array();
	
	/** Initialize the loader variables **/
	public function initialize($controller = NULL) {
		
		/* set the module name */
		$this->_module = CI::$APP->router->fetch_module();
		
		if (is_a($controller, 'MX_Controller')) {	
			
			/* reference to the module controller */
			$this->controller = $controller;
			
			/* references to ci loader variables */
			foreach (get_class_vars('CI_Loader') as $var => $val) {
				if ($var != '_ci_ob_level') {
					$this->$var =& CI::$APP->load->$var;
				}
			}
			
		} else {
			parent::initialize();
			
			/* autoload module items */
			$this->_autoloader(array());
		}
		
		/* add this module path to the loader variables */
		$this->_add_module_paths($this->_module);
	}

	/** Add a module path loader variables **/
	public function _add_module_paths($module = '') {
		
		if (empty($module)) return;
		
		foreach (Modules::$locations as $location => $offset) {
			
			/* only add a module path if it exists */
			if (is_dir($module_path = $location.$module.'/') && ! in_array($module_path, $this->_ci_model_paths)) 
			{
				array_unshift($this->_ci_model_paths, $module_path);
			}
		}
	}	
	
	public function config($file, $use_sections = FALSE, $fail_gracefully = FALSE)
	{
		return get_instance()->config->load($file, $use_sections, $fail_gracefully);
	}

	public function database($params = '', $return = FALSE, $query_builder = NULL)
	{
		// Grab the super object
		$CI =& get_instance();

		// Do we even need to load the database class?
		if ($return === FALSE && $query_builder === NULL && isset($CI->db) && is_object($CI->db) && ! empty($CI->db->conn_id))
		{
			return FALSE;
		}

		require_once(BASEPATH.'database/DB.php');

		if ($return === TRUE)
		{
			return DB($params, $query_builder);
		}

		// Initialize the db variable. Needed to prevent
		// reference errors with some configurations
		$CI->db = '';

		// Load the DB class
		$CI->db =& DB($params, $query_builder);
		return $this;
	}

	public function helper($helpers = array())
	{
		foreach ($this->_ci_prep_filename($helpers, '_helper') as $helper)
		{
			if (isset($this->_ci_helpers[$helper]))
			{
				continue;
			}

			// Is this a helper extension request?
			$ext_helper = config_item('subclass_prefix').$helper;
			$ext_loaded = FALSE;
			foreach ($this->_ci_helper_paths as $path)
			{
				if (file_exists($path.'helpers/'.$ext_helper.'.php'))
				{
					include_once($path.'helpers/'.$ext_helper.'.php');
					$ext_loaded = TRUE;
				}
			}

			// If we have loaded extensions - check if the base one is here
			if ($ext_loaded === TRUE)
			{
				$base_helper = BASEPATH.'helpers/'.$helper.'.php';
				if ( ! file_exists($base_helper))
				{
					show_error('Unable to load the requested file: helpers/'.$helper.'.php');
				}

				include_once($base_helper);
				$this->_ci_helpers[$helper] = TRUE;
				log_message('info', 'Helper loaded: '.$helper);
				continue;
			}

			// No extensions found ... try loading regular helpers and/or overrides
			foreach ($this->_ci_helper_paths as $path)
			{
				if (file_exists($path.'helpers/'.$helper.'.php'))
				{
					include_once($path.'helpers/'.$helper.'.php');

					$this->_ci_helpers[$helper] = TRUE;
					log_message('info', 'Helper loaded: '.$helper);
					break;
				}
			}

			// unable to load the helper
			if ( ! isset($this->_ci_helpers[$helper]))
			{
				show_error('Unable to load the requested file: helpers/'.$helper.'.php');
			}
		}

		return $this;
	}	

	public function helpers($helpers = array())
	{
		return $this->helper($helpers);
	}
	
	public function library($library, $params = NULL, $object_name = NULL)
	{
		if (empty($library))
		{
			return $this;
		}
		elseif (is_array($library))
		{
			foreach ($library as $key => $value)
			{
				if (is_int($key))
				{
					$this->library($value, $params);
				}
				else
				{
					$this->library($key, $params, $value);
				}
			}

			return $this;
		}
		if ($params !== NULL && ! is_array($params))
		{
			$params = NULL;
		}

		$this->_ci_load_library($library, $params, $object_name);
		return $this;
	}

	/** Load a module model **/
	public function model($model, $object_name = NULL, $connect = FALSE) {
		
		if (is_array($model)) return $this->models($model);

		($_alias = $object_name) OR $_alias = basename($model);

		if (in_array($_alias, $this->_ci_models, TRUE)) 
			return CI::$APP->$_alias;
			
		/* check module */
		list($path, $_model) = Modules::find(strtolower($model), $this->_module, 'models/');
		
		if ($path == FALSE) {
			
			/* check application & packages */
			parent::model($model, $object_name, $connect);
			
		} else {
			
			class_exists('CI_Model', FALSE) OR load_class('Model', 'core');
			
			if ($connect !== FALSE AND ! class_exists('CI_DB', FALSE)) {
				if ($connect === TRUE) $connect = '';
				$this->database($connect, FALSE, TRUE);
			}
			
			Modules::load_file($_model, $path);
			
			$model = ucfirst($_model);
			CI::$APP->$_alias = new $model();
			
			$this->_ci_models[] = $_alias;
		}
		
		return CI::$APP->$_alias;
	}

	/** Load an array of models **/
	public function models($models) {
		foreach ($models as $_model) $this->model($_model);	
	}

	/** Load a module controller **/
	public function module($module, $params = NULL)	{
		
		if (is_array($module)) return $this->modules($module);

		$_alias = strtolower(basename($module));
		CI::$APP->$_alias = Modules::load(array($module => $params));
		return CI::$APP->$_alias;
	}

	/** Load an array of controllers **/
	public function modules($modules) {
		foreach ($modules as $_module) $this->module($_module);	
	}

	/** Load a module plugin **/
	public function plugin($plugin)	{
		
		if (is_array($plugin)) return $this->plugins($plugin);		
		
		if (isset($this->_ci_plugins[$plugin]))	
			return;

		list($path, $_plugin) = Modules::find($plugin.'_pi', $this->_module, 'plugins/');	
		
		if ($path === FALSE AND ! is_file($_plugin = APPPATH.'plugins/'.$_plugin.EXT)) {	
			show_error("Unable to locate the plugin file: {$_plugin}");
		}

		Modules::load_file($_plugin, $path);
		$this->_ci_plugins[$plugin] = TRUE;
	}

	/** Load an array of plugins **/
	public function plugins($plugins) {
		foreach ($plugins as $_plugin) $this->plugin($_plugin);	
	}

	/** Load a module view **/
	public function view($view, $vars = array(), $return = FALSE) {
		$path = FALSE;
		if(strpos($view,'.tpl') !== false)
		{
			return $this->smart_view($view, $vars, $return);
		}else if(strpos($view,'.php') === false)
		{
			list($path, $_view) = Modules::find($view.".tpl", $this->_module, 'views/');
			if($path !== FALSE)
				return $this->smart_view($view.".tpl", $vars, $return);
		}
		if($path == FALSE)
			if(strpos($this->_module,'_child') !== false)
			{
				list($path, $_view) = Modules::find($view, $this->_module, 'views/');
				if($path == FALSE)
					list($path, $_view) = Modules::find($view, str_replace("_child", "", $this->_module), 'views/');	
			}else{
				list($path, $_view) = Modules::find($view, $this->_module."_child", 'views/');
				if($path == FALSE)
					list($path, $_view) = Modules::find($view, $this->_module, 'views/');
			}

		if ($path == FALSE && strpos($this->_module,'_child') !== false)
		{
			list($path, $_view) = Modules::find($view, str_replace("_child", "", $this->_module), 'views/');		
		}
		if ($path != FALSE) {
			$this->_ci_view_paths = array($path => TRUE) + $this->_ci_view_paths;
			$view = $_view;
		}
		$path_fragment = explode("/", $path);
		if($path_fragment[0] == "modules")
		{
			global $active_show;
			$controller = &$active_show->controller;

			$theme_path = "themes/".$controller->BuilderEngine->get_option('active_frontend_theme')."/modules/".$this->_module;
			$theme_file = $theme_path."/".$_view.".php";
			if(file_exists($theme_file)){
				$path = "../../".$theme_path;

				$this->_ci_view_paths = array($path => TRUE) + $this->_ci_view_paths;
				$view = $path."/".$_view;
			}

		}
		global $active_show;
		global $BuilderEngine;
		$vars['BuilderEngine'] = &$BuilderEngine;
		


		$vars['versions'] = &$active_show->controller->versions;

		$vars['user'] = &$active_show->controller->user;

		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));

	}

	public function smart_view($view, $vars = array(), $return = FALSE)
	{
		$orgin_view = $view;
		if(!strpos($view,".php") && !strpos($view,".tpl"))
			$view .= ".tpl";
		PC::preparing_view($view);
		$view_name = $view;
		$smarty = new SmartyBC();

        $config =& get_config();

        $this->caching = 1;
        
        $smarty->setCompileDir( APPPATH . '/third_party/Smarty-3.1.8/templates_c' );
        $smarty->setConfigDir( APPPATH . '/third_party/Smarty-3.1.8/configs' );
        $smarty->setCacheDir( APPPATH . '/cache' );



        if(strpos($this->_module,'_child') !== false)
		{
			list($path, $_view) = Modules::find($view, $this->_module, 'views/');
			if($path == FALSE)
				list($path, $_view) = Modules::find($view, str_replace("_child", "", $this->_module), 'views/');	
		}else{
			list($path, $_view) = Modules::find($view, $this->_module."_child", 'views/');
			if($path == FALSE)
				list($path, $_view) = Modules::find($view, $this->_module, 'views/');
		}
		
		if($path == FALSE)
		{
			list($path, $_view) = Modules::find($orgin_view.".php", $this->_module, 'views/');
			if($path != FALSE){
				$view = $orgin_view.".php";
				$view_name = $view;
			}
		}
		

		if ($path == FALSE && strpos($this->_module,'_child') !== false)
		{
			list($path, $_view) = Modules::find($view, str_replace("_child", "", $this->_module), 'views/');		
		}
		if ($path != FALSE) {
			$this->_ci_view_paths = array($path => TRUE) + $this->_ci_view_paths;
			$view = $_view;
		}
		$path_fragment = explode("/", $path);
		if($path_fragment[0] == "modules")
		{
			global $active_show;
			$controller = &$active_show->controller;

			$theme_path = "themes/".$controller->BuilderEngine->get_option('active_frontend_theme')."/modules/".$this->_module;
			$theme_file = $theme_path."/".$_view.".php";
			if(file_exists($theme_file)){
				$path = "../../".$theme_path;

				$this->_ci_view_paths = array($path => TRUE) + $this->_ci_view_paths;
				$view = $path."/".$_view;
			}
			// To be updated
			$view_name = basename($view_name);
		}
		global $active_show;
		global $BuilderEngine;
		$vars['BuilderEngine'] = &$BuilderEngine;
		$vars['versions'] = &$active_show->controller->versions;
		$vars['user'] = &$active_show->controller->user;
		$vars['this'] = &$this;
		$smarty->setTemplateDir( $path );
		foreach($vars as $key => $value)
		{
			$smarty->assign($key, $value);
		}
		$smarty->assign("test_var", "qweqweqwe");
		if($return){
			ob_start();

			$smarty->display( $view_name );
					
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}
		else
			$smarty->display( $view_name );
		/*
		global $active_show;
		global $BuilderEngine;
		$vars['BuilderEngine'] = &$BuilderEngine;
		


		$vars['versions'] = &$active_show->controller->versions;

		$vars['user'] = &$active_show->controller->user;

		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
		*/

	}

	public function _ci_is_instance() {}

	protected function &_ci_get_component($component) {
		return CI::$APP->$component;
	} 

	public function __get($class) {
		return (isset($this->controller)) ? $this->controller->$class : CI::$APP->$class;
	}

	public function _ci_load($_ci_data) {
		
		extract($_ci_data);
		
		if (isset($_ci_view)) {
			
			$_ci_path = '';
			
			/* add file extension if not provided */
			$_ci_file = (pathinfo($_ci_view, PATHINFO_EXTENSION)) ? $_ci_view : $_ci_view.EXT;
			
			foreach ($this->_ci_view_paths as $path => $cascade) {				
				if (file_exists($view = $path.$_ci_file)) {
					$_ci_path = $view;
					break;
				}
				
				if ( ! $cascade) break;
			}
			
		} elseif (isset($_ci_path)) {
			
			$_ci_file = basename($_ci_path);
			if( ! file_exists($_ci_path)) $_ci_path = '';
		}

		if (empty($_ci_path)) 
			show_error('Unable to load the requested file: '.$_ci_file);

		if (isset($_ci_vars)) 
			$this->_ci_cached_vars = array_merge($this->_ci_cached_vars, (array) $_ci_vars);
		
		extract($this->_ci_cached_vars);

		ob_start();

		if ((bool) @ini_get('short_open_tag') === FALSE AND CI::$APP->config->item('rewrite_short_tags') == TRUE) {
			echo eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php echo ', file_get_contents($_ci_path))));
		} else {
			include($_ci_path); 
		}

		log_message('debug', 'File loaded: '.$_ci_path);

		if ($_ci_return == TRUE) return ob_get_clean();

		if (ob_get_level() > $this->_ci_ob_level + 1) {
			ob_end_flush();
		} else {
			CI::$APP->output->append_output(ob_get_clean());
		}
	}	
	
	/** Autoload module items **/
	public function _autoloader($autoload) {
		
		$path = FALSE;
		
		if ($this->_module) {
			
			list($path, $file) = Modules::find('constants', $this->_module, 'config/');	
			
			/* module constants file */
			if ($path != FALSE) {
				include_once $path.$file.EXT;
			}
					
			list($path, $file) = Modules::find('autoload', $this->_module, 'config/');
		
			/* module autoload file */
			if ($path != FALSE) {
				$autoload = array_merge(Modules::load_file($file, $path, 'autoload'), $autoload);
			}
		}
		
		/* nothing to do */
		if (count($autoload) == 0) return;
		
		/* autoload package paths */
		if (isset($autoload['packages'])) {
			foreach ($autoload['packages'] as $package_path) {
				$this->add_package_path($package_path);
			}
		}
				
		/* autoload config */
		if (isset($autoload['config'])) {
			foreach ($autoload['config'] as $config) {
				$this->config($config);
			}
		}

		/* autoload helpers, plugins, languages */
		foreach (array('helper', 'plugin', 'language') as $type) {
			if (isset($autoload[$type])){
				foreach ($autoload[$type] as $item) {
					$this->$type($item);
				}
			}
		}	
			
		/* autoload database & libraries */
		if (isset($autoload['libraries'])) {
			if (in_array('database', $autoload['libraries'])) {
				/* autoload database */
				if ( ! $db = CI::$APP->config->item('database')) {
					$db['params'] = 'default';
					$db['active_record'] = TRUE;
				}
				$this->database($db['params'], FALSE, $db['active_record']);
				$autoload['libraries'] = array_diff($autoload['libraries'], array('database'));
			}

			/* autoload libraries */
			foreach ($autoload['libraries'] as $library) {
				$this->library($library);
			}
		}
		
		/* autoload models */
		if (isset($autoload['model'])) {
			foreach ($autoload['model'] as $model => $alias) {
				(is_numeric($model)) ? $this->model($alias) : $this->model($model, $alias);
			}
		}
		
		/* autoload module controllers */
		if (isset($autoload['modules'])) {
			foreach ($autoload['modules'] as $controller) {
				($controller != $this->_module) AND $this->module($controller);
			}
		}
	}

}

/** load the CI class for Modular Separation **/
(class_exists('CI', FALSE)) OR require dirname(__FILE__).'/Ci.php';