<?php
/**
 * PayPal_Lib Controller Class (Paypal IPN Class)
 *
 * Paypal controller that provides functionality to the creation for PayPal forms, 
 * submissions, success and cancel requests, as well as IPN responses.
 *
 * The class requires the use of the PayPal_Lib library and config files.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Commerce
 * @author      Ran Aroussi <ran@aroussi.com>
 * @copyright   Copyright (c) 2006, http://aroussi.com/ci/
 *
 */

class checkout extends CI_Controller {
	var $data=array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('email');
		$this->data = array_merge($this->data, $this->session->all_userdata());
		$this->data['cart_counter'] = isset($this->data['cart'])? count($this->data['cart']) : 0;
		$this->load->helper(array('form'));
		$this->load->library('paypal_lib');
	}
	
	public function index()	{
		$this->data['title'] = 'Product Catalog';
		$this->load->helper( array('form') );		
		$this->load->library('form_validation');
		
		$this->load->model('product_model');
		$product_details = $this->product_model->get_cart_item_price($this->data['cart']);
		
		foreach($this->data['cart'] as $key=>$each_item){
			foreach ($product_details as $each_product){
				if ($each_product['id'] === $each_item['id']){
					$this->data['cart'][$key]['price'] = $each_product['price'];
					$this->data['cart'][$key]['discount'] = $each_product['discount'];
				}
			}
		}

		$this->load->view('templates/header', $this->data);
		$this->load->view("pages/product", $this->data);
		$this->load->view('templates/footer');
	}

	function payment(){
		$this->load->helper( array('form') );
		$this->load->library('form_validation');
		$this->form_validation->set_rules('pg', 'lang:payment_gateway', 'required|integer|xss_clean');
		
		if($this->form_validation->run() == TRUE) {
			if (count($this->data['cart'])>0){
				if ($this->input->post("pg")==="0"){
					$this->paypal();
				}else if ($this->input->post("pg")==="1"){
					$this->alipay();
				}
			}else{
				echo "";
			}
		}else{
			echo "";
		}
	}
	
	function paypal(){
		$this->data['payment_gateway'] = 'paypal';
		$this->data['paypal_id'] = 'jendro_1334808935_biz@gmail.com';
		$this->data['payment_url'] = $this->paypal_lib->paypal_url;
		
		$this->load->model('product_model');
		//$cart_items = array(array("name"=>"basketball", "id"=>"0011", "amount"=>600, "qty"=>3),array("name"=>"football", "id"=>"0021", "amount"=>1200, "qty"=>1));
		$product_details = $this->product_model->get_cart_item_price($this->data['cart']);
		
		foreach($this->data['cart'] as $key=>$each_item){
			foreach ($product_details as $each_product){
				if ($each_product['id'] === $each_item['id']){
					$this->data['cart'][$key]['price'] = $each_product['price'];
					$this->data['cart'][$key]['discount'] = $each_product['discount'];
				}
			}
		}
		echo $this->load->view("pages/product", $this->data, true);
		/*
		$fields = array(
			'cmd'=>urlencode("_cart"),
			'upload'=>urlencode("1"),
			'business'=>urlencode("Casimira"),
			'currency_code'=>urlencode("Casimira"),
			'lc'=>urlencode("US"),
			'rm'=>urlencode("2"),
			'shipping_1'=>urlencode("Shipping address 111"),
			'return'=>urlencode(site_url().$this->lang->lang()."/cart-details"),
			'cancel_return'=>urlencode(site_url().$this->lang->lang()."/cancel_return"),
			'notify_url'=>urlencode(site_url().$this->lang->lang()."/paypal/paypal_ipn")
		);		
		
		foreach($this->data['cart'] as $key=>$each_item){
			$fields["item_name_".$key] = $each_item['id'].$each_item['color'].$each_item['size'];
			$fields["item_number_".$key] = $each_item['id'];
			$fields["amount"] = $each_item['price']-$each_item['discount'];
			$fields["quantity_".$key] = $each_item['quantity'];
		}
		
		//url-ify the data for the POST
		$fields_string="";
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string,'&');

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $this->data['payment_url']);
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

		//execute post
		$result = curl_exec($ch);
		*/
	}
	
	function alipay(){
		$this->data['payment_gateway'] = 'alipay';
		$this->data['payment_url'] = "alipay.com";//$this->paypal_lib->paypal_url
		
		$this->load->view('templates/header', $this->data);
		$this->load->view("pages/product", $this->data);
		$this->load->view('templates/footer');
	}

	

	function cancel()
	{
		$this->load->view('paypal/cancel');
	}
	
	function success()
	{
		// This is where you would probably want to thank the user for their order
		// or what have you.  The order information at this point is in POST 
		// variables.  However, you don't want to "process" the order until you
		// get validation from the IPN.  That's where you would have the code to
		// email an admin, update the database with payment status, activate a
		// membership, etc.
	
		// You could also simply re-direct them to another page, or your own 
		// order status page which presents the user with the status of their
		// order based on a database (which can be modified with the IPN code 
		// below).

		$this->data['pp_info'] = $this->input->post();
		$this->load->view('cart/success', $this->data);
		
		
		$this->load->model("order_model");
		$this->order_model->insert_order($this->input->post());
	}
	
	function paypal_ipn()
	{
		// Payment has been received and IPN is verified.  This is where you
		// update your database to activate or process the order, or setup
		// the database with the user's order details, email an administrator,
		// etc. You can access a slew of information via the ipn_data() array.
 
		// Check the paypal documentation for specifics on what information
		// is available in the IPN POST variables.  Basically, all the POST vars
		// which paypal sends, which we send back for validation, are now stored
		// in the ipn_data() array.
 
		// For this example, we'll just email ourselves ALL the data.
		$to    = 'davidrobinson91@hotmail.com';    //  your email
		
		if ($this->paypal_lib->validate_ipn()) 
		{
			//$this->paypal_lib->ipn_data['payer_email'] = $to;
			$body  = 'An instant payment notification was successfully received from ';
			$body .= $this->paypal_lib->ipn_data['payer_email'] . ' on '.date('m/d/Y') . ' at ' . date('g:i A') . "\n\n";
			$body .= " Details:\n";
			
			if (($this->paypal_lib->ipn_data['payment_status'] == 'Completed') /*&&
				($this->paypal_lib->ipn_data['receiver_email'] == $our_email) &&
				($this->paypal_lib->ipn_data['payment_amount'] == $amount_they_should_have_paid ) &&
				($this->paypal_lib->ipn_data['payment_currency'] == "USD")*/)
				{
					foreach ($this->paypal_lib->ipn_data as $key=>$value){
						$body .= "\n$key: $value";
					}
					$subject = "Live-VALID IPN";
				}
			
				//insert data to the database
				
			
			// load email lib and email results
			$this->load->library('email');
						
			$this->email->to($to);
			$this->email->from($this->paypal_lib->ipn_data['payer_email'], $this->paypal_lib->ipn_data['payer_name']);
			$this->email->subject($subject);
			$this->email->message($body);	
			$this->email->send();
			echo "OKOK";
		}else{
			foreach ($this->paypal_lib->ipn_data as $key=>$value){
				$body .= "\n$key: $value";
			}
			$this->paypal_lib->log_results("ERRER");
			echo "EERR";
		}
		print_r($this->paypal_lib->ipn_data);
		$this->paypal_lib->log_results("dfdg");
	}
}
?>