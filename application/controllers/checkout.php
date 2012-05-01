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

class checkout extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('email');
		$this->load->helper(array('form'));
		$this->load->library('paypal_lib');
	}
	
	public function index()	{
		$this->data['page']['title'] = 'Product Catalog';
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
		$this->load->model(array("order_model"));
		$this->load->helper( array('form') );
		$this->load->library('form_validation');
		$this->form_validation->set_rules('pg', 'lang:payment_gateway', 'required|integer|xss_clean');		
		
		if($this->form_validation->run() == TRUE) {
			if (count($this->data['cart'])>0){
				if ($this->input->post("pg")==="0"){
					// insert to database order					
					$this->paypal();
				}else if ($this->input->post("pg")==="1"){
					$this->alipay();
				}
			}else{
				echo "-999";
			}
		}else{
			echo "-999";
		}
	}
	
	function paypal(){
		$this->data['payment']=array();
		
		$this->data['payment']['gateway'] = 'paypal';
		$this->data['payment']['paypal_id'] = 'jendro_1334808935_biz@gmail.com';
		$this->data['payment']['payment_url'] = $this->paypal_lib->paypal_url;
		
		
		$this->load->model('product_model');
		$this->load->model("order_model");

		$product_details = $this->product_model->get_cart_item_price($this->data['cart']);

		foreach($this->data['cart'] as $key=>$each_item){
			foreach ($product_details as $each_product){
				if ($each_product['id'] === $each_item['id']){
					$this->data['cart'][$key]['price'] = $each_product['price'];
					$this->data['cart'][$key]['discount'] = $each_product['discount'];
				}
			}
		}
		
		$order_id = $this->order_model->insert_checkout_item($this->data['cart']);
		
		$this->data['payment']['success_url']= site_url().$this->lang->lang()."/checkout/success";
		$this->data['payment']['cancel_url']= site_url().$this->lang->lang()."/checkout/cancel/$order_id";
		$this->data['payment']['notify_url']= site_url().$this->lang->lang()."/checkout/paypal_ipn/$order_id";
				
		echo $this->load->view("pages/product", $this->data, true);
		
	}
	
	function alipay(){
		$this->data['payment']['gateway'] = 'alipay';
		$this->data['payment']['payment_url'] = "alipay.com";//$this->paypal_lib->paypal_url
		
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
	}
	
	function paypal_ipn($uuid)
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
			$body .= $this->input->post('payer_email') . ' on '.date('m/d/Y') . ' at ' . date('g:i A') . "\n\n";
			$body .= " Details:\n";
			
			if (($this->input->post('payment_status') == 'Completed') /*&&
				($this->input->post('receiver_email') == $our_email) &&
				($this->input->post('payment_amount') == $amount_they_should_have_paid ) &&
				($this->input->post('payment_currency') == "USD")*/)
			{
				$this->order_model->update_paypal_order($uuid);
				
				$session_data = $this->data = $this->session->all_userdata();
				// clear the cart data
				$session_data['cart'] = array();
				$this->data['cart'] = array();				
				$this->session->set_userdata($session_data);
				
				foreach ($this->input->post() as $key=>$value){
					$body .= "\n$key: $value";
				}
				$subject = "Live-VALID IPN";
			}
			
			
			$this->order_model->insert_paypal_order($this->input->post());
			
			// load email lib and email results
			$this->load->library('email');						
			$this->email->to($to);
			$this->email->from($this->paypal_lib->ipn_data['payer_email'], $this->paypal_lib->ipn_data['payer_name']);
			$this->email->subject($subject);
			$this->email->message($body);	
			$this->email->send();
		}else{
			$this->paypal_lib->log_results("ERRER");
		}
	}
}
?>