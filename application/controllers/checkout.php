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
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('user_model', 'order_model'));
		$this->load->library('email');
		$this->load->library('paypal_lib');
		$this->load->helper(array('form'));
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
	
		if (!$this->is_login()){
			//$url = site_url().$this->lang->lang()."/login";
			$this->load->library('form_validation');
			$this->data['page']['login_url'] = site_url().$this->lang->lang()."/login/";
			echo $this->load->view('account/login_ajax_form', $this->data, true);
			exit();
		}
		
		$this->load->model('product_model');
		$this->load->model(array("order_model"));
		$this->load->helper( array('form') );
		
			// the session contains the alipay_submit or paypal_submit
		if (isset($_POST['pg'])){
			// 0 = paypal
			// 1 = alipay
			if ($_POST['pg']==="0" || $_POST['pg']==="1"){
				$this->set_session('page', array('pg'=>$_POST['pg']));
				$this->data['page']['pg'] = $_POST['pg'];
			}
		}
		
		// save cart checkout		
		$this->set_session('page', array('next_page'=>site_url().$this->lang->lang()."/cart"));

		if(count($this->data['cart'])>0 && isset($this->data['page']['pg'])) {
			// get the price from the database and put in the $this->data['cart']
			$product_details = $this->product_model->get_cart_item_price($this->data['cart']);
			foreach($this->data['cart'] as $key=>$each_item){
				foreach ($product_details as $each_product){
					if ($each_product['id'] === $each_item['id']){
						$this->data['cart'][$key]['price'] = $each_product['price'];
						$this->data['cart'][$key]['discount'] = $each_product['discount'];
						$this->data['cart'][$key]['name_zh'] = $each_product['name_zh'];
						$this->data['cart'][$key]['name_en'] = $each_product['name_en'];
					}
				}
			}
			
			if ($this->data['page']['pg']==="0"){
				$this->paypal();
			}else if ($this->data['page']['pg']==="1"){
				$this->alipay();
			}
		}
	}
	
	private function paypal(){
		$this->load->model("order_model");
		$this->load->library('paypal_lib');
		
		// always create a new order number
		$order_keys = $this->order_model->insert_checkout_item($this->data);
		//if (!isset($this->data['page']['rand_key'])){
			
		// $order_keys : array('rand_key'=>value1, 'order_id'=>value2);
		$this->set_session('page', $order_keys);
		$this->data['page']['rand_key'] = $order_keys['rand_key'];
		$this->data['page']['order_id'] = $order_keys['order_id'];
		//var_dump($this->get_session());
		//var_dump($this->data['page']);
		//}

		echo <<<HTML
		<div id="content" class="container" style="margin-top:10em;">
			<div class="content expando">
				We are connecting you to Paypal. <br/>
				Please do not close the browser. Thank you.<br/>
HTML;
		echo $this->paypal_lib->build_form($this->data);
		echo <<<HTML
			</div>
		</div>
HTML;

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
		// clear cart
		$session_data = $this->session->all_userdata();
		$session_data['cart'] = array();
		// clear order id (invoice number) and rand_key		
		$session_data['page']['order_id']='';
		$session_data['page']['rand_key']='';
		$this->session->set_userdata($session_data);
		
		$this->data['cart'] = array();
		$this->data['page']['rand_key']="";
		$this->data['page']['order_id']="";
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/payment_cancel');
		$this->load->view('templates/footer');
		
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
		
		// clear cart
		$session_data = $this->session->all_userdata();
		$session_data['cart'] = array();
		// clear order id (invoice number) and rand_key		
		$session_data['page']['order_id']='';
		$session_data['page']['rand_key']='';
		$this->session->set_userdata($session_data);
		
		$this->data['cart'] = array();
		$this->data['page']['rand_key']="";
		$this->data['page']['order_id']="";
		//exit();
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/payment_success', $this->data);
		$this->load->view('templates/footer');
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
		
		$body ="";
		foreach ($_POST as $key=>$value){
			$data .= "\n$key: $value";
		}
		
		if ($this->paypal_lib->validate_ipn())
		{
			//$this->paypal_lib->ipn_data['payer_email'] = $to;
			$body .= 'An instant payment notification was successfully received from ';
			$body .= $this->input->post('payer_email') . ' on '.date('m/d/Y') . ' at ' . date('g:i A') . "\n\n";
			$body .= " Details:\n";
			$body .= $data;
			
			if (($this->input->post('payment_status') === 'Completed') //&&
				//($this->input->post('receiver_email') == 'info@casimira.com.hk') //&&
				//($this->input->post('payment_amount') == $amount_they_should_have_paid ) &&
				//($this->input->post('payment_currency') == "USD")*/
				)
			{
				
				// update the transaction id retreived form paypal to orders, orders_items and order_address table
				$this->order_model->update_paypal_order();
				$this->paypal_lib->log_results($body);
				$subject = "Live-VALID IPN";
			}
			
			// load email lib and email results
			$this->load->library('email');
			$this->email->to(array($to,$this->data['user']['email']));
			$this->email->from($this->paypal_lib->ipn_data['payer_email'], $this->paypal_lib->ipn_data['payer_name']);
			$this->email->subject($subject);
			$this->email->message($body);
			$this->email->send();
		}else{
			$this->paypal_lib->log_results("error: ".$body);
			$subject = "Casimira Payment Failure";
			
			$this->load->library('email');
			
			$this->email->to($to);
			$this->email->from($this->paypal_lib->ipn_data['payer_email'], $this->paypal_lib->ipn_data['payer_name']);
			$this->email->subject($subject);
			$this->email->message("Sorry! Your transaction failed. Please try again");
			$this->email->send();
		}
	}
}
?>