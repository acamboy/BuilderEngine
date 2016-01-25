<?php
	require_once('Paymentgateway.php');
    require_once('stripe/lib/Stripe.php');
    class StripeGateway extends PaymentGateway
	{
		public function process($order)
		{
			$this->load_config();
			$data['config'] = $this->m_config;
			$data['order'] = $order;
			
			$this->load->view('stripe/stripe_credit_card', $data);
			
		}
		
        public function process_payment($order_id)
		{
            error_reporting(0);
			$order = $this->api->getOrderByID($order_id);
			$this->load_config();
            $sandbox = true;
            if($this->m_config['STRIPE_SANDBOX'])
                $sandbox = false;
            
            $amount = $order->gross*100;
			$currency = $order->currency;
			$cardnumber = str_replace(" ","",$_POST['credit_card_number']);
			$cardname = $_POST['credit_card_name'];
			$cardtype = $_POST['credit_card_type'];
			$cvnnumber = $_POST['credit_card_cvn'];
			$expdate = $_POST['credit_card_exp_month'].$_POST['credit_card_exp_year'];
            
			// API credentials only need to be defined once
            define("STRIPE_TEST_API_KEY", $this->m_config['STRIPE_TEST_API_KEY']);
            define("STRIPE_LIVE_API_KEY", $this->m_config['STRIPE_LIVE_API_KEY']);
            define("STRIPE_SANDBOX", $sandbox);
            
            if($sandbox)
                Stripe::setApiKey(STRIPE_TEST_API_KEY);
            else
                Stripe::setApiKey(STRIPE_LIVE_API_KEY);

            $c = Stripe_Charge::create(array(
                  "amount" => $amount,
                  "currency" => $order->currency,
                  "card" => array(
                              'number' => $cardnumber,
                              'exp_month' => $_POST['credit_card_exp_month'],
                              'exp_year' => $_POST['credit_card_exp_year']
                            ), // obtained with Stripe.js
                  "description" => "Charge for ".$cardname
                ), array(
                  "idempotency_key" => $_POST['idempotency_key'],
                ));

            if ($c->paid)
            {
                $order->paid();
				echo "<h2>Your payment was successfully processed. Thank you!</h2>";
                echo "Success! Transaction ID:" . $c->receipt_number;
            }
            else
            {
                echo "<h2>Your card was declined.</h2>";
            }
		}
        
		public function details()
		{
			return array(
			    "id"			=> "stripe",
				"name"			=> "Stripe",
				"logo_big"		=> "https://resourcecentre.realexpayments.com/templates/realex/images/logo.gif",
				"logo_small"	=> "",
			);
		}
        
		public function default_config()
		{
			$this->config_set('stripe', '');
			$this->config_set('STRIPE_LIVE_API_KEY', '');
			$this->config_set('STRIPE_TEST_API_KEY', '');
            $this->config_set('STRIPE_SANDBOX', 0);
            $this->config_set('active', 'no');
		}
        
		public function get_config()
		{
		}
        
		public function is_available()
		{
			return true;
			$encoded_settings = $this->BuilderEngine->get_option('be_builderpayment_stripe_settings');
			if($encoded_settings == '')
				return false;
			$settings = json_decode($encoded_settings);
			return strlen($settings->STRIPE_TEST_API_KEY) > 3 || strlen($settings->STRIPE_LIVE_API_KEY) > 3 && $settings->active == 'yes';
		}
        
		public function test($var)
		{
			echo $var;
		}
        
		public function admin()
		{
			$this->load->module("builderpayment/stripegateway");
			$realex = new StripeGateway();
			$realex->load_config();
			if($_POST)
			{
				$realex->config_set('STRIPE_TEST_API_KEY', $_POST['STRIPE_TEST_API_KEY']);
                $realex->config_set('STRIPE_LIVE_API_KEY', $_POST['STRIPE_LIVE_API_KEY']);
				$realex->config_set('active', $_POST['active']);
				$realex->config_set('STRIPE_SANDBOX', $_POST['STRIPE_SANDBOX']);
				$realex->save_config();
			}
			$data['STRIPE_TEST_API_KEY'] = $realex->config_get('STRIPE_TEST_API_KEY');
			$data['STRIPE_LIVE_API_KEY'] = $realex->config_get('STRIPE_LIVE_API_KEY');
			$data['STRIPE_SANDBOX'] = $realex->config_get('STRIPE_SANDBOX');
			$data['active'] = $realex->config_get('active');
			$this->load->view('stripe/settings.php', $data);
		}
	}
?> 