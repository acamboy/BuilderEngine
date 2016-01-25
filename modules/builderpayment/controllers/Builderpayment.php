<?php
	class Builderpayment extends Module_Controller
	{
		function test()
		{
			$this->load->module('builderpayment/api');
			$this->api->identifyModule('ecommerce');

			$this->api->setGateway("realex");
			$order = $this->api->createOrder();
			$order->currency = "USD";
			$order->callback = "page/callback";
			$order->save();
			$ship = $order->createShippingAddress();
			$ship->first_name = "Dimitar";
			$ship->middle_name = "Todorov";
			$ship->last_name = "Krastev";
			$ship->save();

			$bill = $order->createBillingAddress();
			$bill->first_name = "Alfonso";
			$bill->save();

			$product = $order->addProduct();
			$product->name = "iPhone 5s Super";
			$product->price = 123;
			$product->quantity = 3;
			$product->save();
			$order->submit();
		}
		function test2()
		{
			
		}
		public function callback()
		{
			
		}
		public function processOrder($order_id)
		{
			$this->load->module('builderpayment/api');
			$order = new BuilderPaymentOrder($order_id);
			$this->api->submitOrder($order);
		}

		public function process($order_id)
		{
			
		}
	}
?>