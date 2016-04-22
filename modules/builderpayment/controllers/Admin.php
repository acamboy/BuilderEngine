<?php
	class Admin extends Module_Controller
	{
		public function gateway_settings()
		{
			$args = func_get_args();
			$gateway = array_shift($args);
			$function = array_shift($args);

			$handler = $gateway."Gateway";
			$this->load->module("builderpayment/paypalgateway");
			call_user_func_array(array($this->paypalgateway, $function), $args);
		}

		// [MenuItem("Payments/PayPal")]
		public function paypal_settings()
		{
			if($_POST)
			{
				$this->BuilderEngine->set_option('be_builderpayment_paypal_settings', json_encode($_POST));
				
			}
			$encoded_settings = $this->BuilderEngine->get_option('be_builderpayment_paypal_settings');
			if($encoded_settings == "")
			{
				$settings['paypal_address'] = "";
				$settings['active'] = 'no';
				$settings = (object)$settings;
				$this->BuilderEngine->set_option('be_builderpayment_paypal_settings', json_encode($settings));
			}else
				$settings = json_decode($encoded_settings);

			$this->load->view('paypal/settings.php', array('settings' => $settings));
		}

		// [MenuItem("Payments/Realex Payments")]
		public function realex_settings()
		{
			echo Modules::Run("builderpayment/realexgateway/admin");
			
		}
		
        // [MenuItem("Payments/Stripe")]
		public function stripe_settings()
		{
			if (!extension_loaded('mbstring')) {
				$data['info'] = '<i class="fa fa-exclamation-triangle"></i> Stripe needs the Multibyte String PHP extension.To enable it,you must contact your hosting provider.';
				$this->load->view('builderpayment/stripe/stripe_info', $data);
			}else
				echo Modules::Run("builderpayment/stripegateway/admin");
		}
        
        // [MenuItem("Payments/Authorize.net")]
		public function authorize_settings()
		{
			echo Modules::Run("builderpayment/authorizegateway/admin");
		}
	}
?>