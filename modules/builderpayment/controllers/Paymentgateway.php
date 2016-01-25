<?php
	class PaymentGateway extends Module_Controller
	{
		protected $m_config = array();

		function __construct()
		{
			parent::__construct();
			$this->load->module('builderpayment/api');
		}
		public function load_config()
		{
			global $active_show;
			$this->default_config();
			$config = $this->get_builderengine()->get_option("builderpayment-config-".get_class($this));
			if($config != "")
				$this->m_config = json_decode($config, true);
		}

		public function save_config()
		{
			$this->get_builderengine()->set_option("builderpayment-config-".get_class($this), json_encode($this->m_config) );
		}

		public function config_get($key)
		{
			return $this->m_config[$key];
		}
		public function config_set($key, $value)
		{
			$this->m_config[$key] = $value;
		}
		public function is_available()
		{
			return true;
		}

	}
?>