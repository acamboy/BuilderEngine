<?php
	function startElement($parser, $name, $attrs) {
	    global $parentElements;
		global $currentElement;
		global $currentTSSCheck;
		
		array_push($parentElements, $name);
		$currentElement = join("_", $parentElements);

		foreach ($attrs as $attr => $value) {
			if ($currentElement == "RESPONSE_TSS_CHECK" and $attr == "ID") {
				$currentTSSCheck = $value;
			}

			$attributeName = $currentElement."_".$attr;
			// print out the attributes..
			//print "$attributeName\n";

			global $$attributeName;
			$$attributeName = $value;
		}

		// uncomment the "print $currentElement;" line to see the names of all the variables you can 
		// see in the response.
		// print $currentElement;

	}

	/* The "cDataHandler()" function is called when the parser encounters any text that's 
	   not an element. Simply places the text found in the variable that 
	   was last created. So using the XML example above the text "Owen"
	   would be placed in the variable $RESPONSE_SOMETHING
	*/

	function cDataHandler($parser, $cdata) {
		global $currentElement;
		global $currentTSSCheck;
		global $TSSChecks;

		if ( trim ( $cdata ) ) { 
			if ($currentTSSCheck != 0) {
				$TSSChecks["$currentTSSCheck"] = $cdata;
			}

			global $$currentElement;
			$$currentElement .= $cdata;
		}
		
	}
	function endElement($parser, $name) {
	    global $parentElements;
		global $currentTSSCheck;

		$currentTSSCheck = 0;
		array_pop($parentElements);
	}

	require_once('Paymentgateway.php');
	class RealexGateway extends PaymentGateway
	{
		public function process($order)
		{
			$this->load_config();
			$data['config'] = $this->m_config;
			$data['order'] = $order;

			if($this->config_get('method') == "hosted" || $this->config_get('method') == "")
				$this->load->view('realex/realex_redirect', $data);	
			else if($this->config_get('method') == "remote")
			{
				$this->load->view('realex/remote_request_credit_card', $data);
			}

		}
		public function process_remote($order_id)
		{
			error_reporting(0);
			$order = $this->api->getOrderByID($order_id);
			$this->load_config();

			$parentElements = array();
			$TSSChecks = array();
			$currentElement = 0;
			$currentTSSCheck = "";


			// In this example the values are hardcoded in.In reality they should be read in by a script or from a database.
			$amount = $order->gross*100;
			$currency = $order->currency;
			$cardnumber = str_replace(" ","",$_POST['credit_card_number']);
			$cardname = $_POST['credit_card_name'];
			$cardtype = $_POST['credit_card_type'];
			$cvnnumber = $_POST['credit_card_cvn'];
			$expdate = $_POST['credit_card_exp_month'].$_POST['credit_card_exp_year'];

			// These values will be provided to you by realex Payments, if you have not already received them please contact us
			$merchantid = $this->m_config['merchant_id'];
			$secret = $this->m_config['secret'];
			$account = "";



			//Creates timestamp that is needed to make up orderid
			$timestamp = strftime("%Y%m%d%H%M%S");
			mt_srand((double)microtime()*1000000);


			//You can use any alphanumeric combination for the orderid.Although each transaction must have a unique orderid.
			$orderid = $timestamp."-".mt_rand(1, 999);


			// This section of code creates the md5hash that is needed
			$tmp = "$timestamp.$merchantid.$orderid.$amount.$currency.$cardnumber";
			$md5hash = md5($tmp);
			$tmp = "$md5hash.$secret";
			$md5hash = md5($tmp);


			// Create and initialise XML parser
			$xml_parser = xml_parser_create();
			xml_set_element_handler($xml_parser, "startElement", "endElement");
			xml_set_character_data_handler($xml_parser, "cDataHandler");

			//A number of variables are needed to generate the request xml that is send to Realex Payments.
			$xml = "<request type='auth' timestamp='$timestamp'>
				<merchantid>$merchantid</merchantid>
				<account>$account</account>
				<orderid>$orderid</orderid>
				<amount currency='$currency'>$amount</amount>
				<card> 
					<number>$cardnumber</number>
					<expdate>$expdate</expdate>
					<type>$cardtype</type>
					<chname>$cardname</chname>
					<cvn>
						<number>{$cvnnumber}</number>
						<presind>1</presind>
					</cvn>
				</card> 
				<autosettle flag='1'/>
				<md5hash>$md5hash</md5hash>
				<tssinfo>
					<address type=\"billing\">
						<country>ie</country>
					</address>
				</tssinfo>
			</request>";
			    

			// Send the request array to Realex Payments
			$ch = curl_init();    
			curl_setopt($ch, CURLOPT_URL, "https://epage.payandshop.com/epage-remote.cgi");
			curl_setopt($ch, CURLOPT_POST, 1); 
			curl_setopt($ch, CURLOPT_USERAGENT, "payandshop.com php version 0.9"); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //This should always be set to 'TRUE' when in production to ensure the SSL is enabled.
			$response = curl_exec ($ch);     
			curl_close ($ch); 

			//Tidy it up
			$response = eregi_replace ( "[[:space:]]+", " ", $response );
			$response = eregi_replace ( "[\n\r]", "", $response );

			// parse the response xml
			if (!xml_parse($xml_parser, $response)) {
			    die(sprintf("XML error: %s at line %d",
			           xml_error_string(xml_get_error_code($xml_parser)),
			           xml_get_current_line_number($xml_parser)));
			}


			// garbage collect the parser.
			xml_parser_free($xml_parser);
			$xml = simplexml_load_string($response);
			$json = json_encode($xml);
			$result = json_decode($json,TRUE);

			if($result['result'] == "00")
			{
				$order->paid();
				echo "<h2>Your payment was successfully processed. Thank you!</h2>";
			}else
			{
				echo "<h2>Your card was declined.</h2>";
			}
		}
		public function ipn()
		{
			$this->show->disable_full_wrapper();

			$timestamp = $_POST['TIMESTAMP'];
			$result = $_POST['RESULT'];
			$orderid = $_POST['ORDER_ID'];
			$message = $_POST['MESSAGE'];
			$authcode = $_POST['AUTHCODE'];
			$pasref = $_POST['PASREF'];
			$realexsha1 = $_POST['SHA1HASH'];

			$this->load_config();

			$merchantid = $this->config_get('merchant_id');
			$secret = $this->config_get('secret');


			$tmp = "$timestamp.$merchantid.$orderid.$result.$message.$pasref.$authcode";
			$sha1hash = sha1($tmp);
			$tmp = "$sha1hash.$secret";
			$sha1hash = sha1($tmp);

			//Check to see if hashes match or not
			if ($sha1hash != $realexsha1) {
				echo "Hashes don't match - response not authenticated!";
			}

			if($result == "00" || $result == "101" || $result == "103" || $result == "205")
				$data['status_code'] = $result;
			else
				$data['status_code'] = "default_error";

			if($result == "00")
			{
				$order = $this->api->getOrderByID($orderid);
				$order->paid();
				$order->save();
			}

			$this->load->view('realex/ipn/result.php', $data);

		}
		public function details()
		{
			return array(
			    "id"			=> "realex",
				"name"			=> "RealEx",
				"logo_big"		=> "https://resourcecentre.realexpayments.com/templates/realex/images/logo.gif",
				"logo_small"	=> "",
			);
		}
		public function default_config()
		{
			$this->config_set('merchant_id', '');
			$this->config_set('secret', '');
			$this->config_set('active', 'no');
			$this->config_set('method', 'hosted');
		}
		public function get_config()
		{

		}

		public function is_available()
		{
			return true;
			$encoded_settings = $this->BuilderEngine->get_option('be_builderpayment_realex_settings');
			if($encoded_settings == '')
				return false;

			$settings = json_decode($encoded_settings);
			return strlen($settings->client_id) > 3 && strlen($settings->secret) > 3 && $settings->active == 'yes';
		}
		public function test($var)
		{
			echo $var;
		}

		public function admin()
		{
			$this->load->module("builderpayment/realexgateway");
			$realex = new RealexGateway();
			$realex->load_config();

			if($_POST)
			{
				$realex->config_set('merchant_id', $_POST['merchant_id']);
				$realex->config_set('secret', $_POST['secret']);
				$realex->config_set('active', $_POST['active']);
				$realex->config_set('method', $_POST['method']);
				$realex->save_config();
			}
			$data['merchant_id'] = $realex->config_get('merchant_id');
			$data['secret'] = $realex->config_get('secret');
			$data['method'] = $realex->config_get('method');
			$data['active'] = $realex->config_get('active');

			$this->load->view('realex/settings.php', $data);
		}
	}
?> 