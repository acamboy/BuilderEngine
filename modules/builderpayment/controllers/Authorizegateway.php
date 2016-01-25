<?php
	require_once('Paymentgateway.php');
    require_once('authorizelib/AuthorizeNet.php');
	class AuthorizeGateway extends PaymentGateway
	{
		public function process($order)
		{
			$this->load_config();
			$data['config'] = $this->m_config;
			$data['order'] = $order;
			
			$this->load->view('authorize/authorize_credit_card', $data);
			
		}
		
        public function process_payment($order_id)
		{
            error_reporting(0);
			$order = $this->api->getOrderByID($order_id);
			$this->load_config();
            $sandbox = true;
            if($this->m_config['AUTHORIZENET_SANDBOX'])
                $sandbox = false;
            
            $amount = $order->gross*100;
			$currency = $order->currency;
			$cardnumber = str_replace(" ","",$_POST['credit_card_number']);
			$cardname = $_POST['credit_card_name'];
			$cardtype = $_POST['credit_card_type'];
			$cvnnumber = $_POST['credit_card_cvn'];
			$expdate = $_POST['credit_card_exp_month'].$_POST['credit_card_exp_year'];
            
			// API credentials only need to be defined once
            define("AUTHORIZENET_API_LOGIN_ID", $this->m_config['AUTHORIZENET_API_LOGIN_ID']);
            define("AUTHORIZENET_TRANSACTION_KEY", $this->m_config['AUTHORIZENET_TRANSACTION_KEY']);
            define("AUTHORIZENET_SANDBOX", $sandbox);
            
            $sale = new AuthorizeNetAIM;
            $sale->amount = $amount;
            $sale->card_num = $cardnumber;
            $sale->exp_date = $expdate;
            if($this->m_config['transaction_method'] == 'authorization')
                $response = $sale->authorizeOnly();
            elseif($this->m_config['transaction_method'] == 'capture')
                $response = $sale->authorizeAndCapture();
            if ($response->approved)
            {
                $order->paid();
				echo "<h2>Your payment was successfully processed. Thank you!</h2>";
                echo "Success! Transaction ID:" . $response->transaction_id;
            }
            else
            {
                echo "<h2>Your card was declined.</h2>";
            }
		}
        
		public function details()
		{
			return array(
			    "id"			=> "authorize",
				"name"			=> "Authorize.net",
				"logo_big"		=> "https://resourcecentre.realexpayments.com/templates/realex/images/logo.gif",
				"logo_small"	=> "",
			);
		}
        
		public function default_config()
		{
			$this->config_set('AUTHORIZENET_API_LOGIN_ID', '');
			$this->config_set('AUTHORIZENET_TRANSACTION_KEY', '');
			$this->config_set('AUTHORIZENET_SANDBOX', 0);
            $this->config_set('transaction_method', 'capture');
            $this->config_set('active', 'no');
		}
        
		public function get_config()
		{
		}
        
		public function is_available()
		{
			return true;
			$encoded_settings = $this->BuilderEngine->get_option('be_builderpayment_authorize_settings');
			if($encoded_settings == '')
				return false;
			$settings = json_decode($encoded_settings);
			return strlen($settings->AUTHORIZENET_API_LOGIN_ID) > 3 && strlen($settings->AUTHORIZENET_TRANSACTION_KEY) > 3 && $settings->active == 'yes';
		}
        
		public function test($var)
		{
			echo $var;
		}
        
		public function admin()
		{
			$this->load->module("builderpayment/authorizegateway");
			$realex = new AuthorizeGateway();
			$realex->load_config();
			if($_POST)
			{
				$realex->config_set('AUTHORIZENET_API_LOGIN_ID', $_POST['AUTHORIZENET_API_LOGIN_ID']);
				$realex->config_set('AUTHORIZENET_TRANSACTION_KEY', $_POST['AUTHORIZENET_TRANSACTION_KEY']);
                $realex->config_set('transaction_method', $_POST['transaction_method']);
				$realex->config_set('active', $_POST['active']);
				$realex->config_set('AUTHORIZENET_SANDBOX', $_POST['AUTHORIZENET_SANDBOX']);
				$realex->save_config();
			}
			$data['AUTHORIZENET_API_LOGIN_ID'] = $realex->config_get('AUTHORIZENET_API_LOGIN_ID');
			$data['AUTHORIZENET_TRANSACTION_KEY'] = $realex->config_get('AUTHORIZENET_TRANSACTION_KEY');
			$data['AUTHORIZENET_SANDBOX'] = $realex->config_get('AUTHORIZENET_SANDBOX');
            $data['transaction_method'] = $realex->config_get('transaction_method');
			$data['active'] = $realex->config_get('active');
			$this->load->view('authorize/settings.php', $data);
		}
	}
?> 