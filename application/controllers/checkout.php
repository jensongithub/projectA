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
		$this->load->helper(array('form'));
		$this->load->library('paypal_lib');
	}
	
	public function index($payment_gateway)	{
		$data['title'] = 'Product Catalog';
		
		$this->load->helper( array('form') );
		//$this->lang->load('register');
		$this->load->library('form_validation', 'session');
		
		//$this->form();
		
		$this->load->view('templates/header', $data);
		$this->load->view("pages/product", $data);
		$this->load->view('templates/footer');
	}

	function paypal(){
		$data['payment_gateway'] = 'paypal';
		$data['paypal_url'] = $this->paypal_lib->paypal_url;
		$this->load->view('templates/header', $data);
		$this->load->view("pages/product", $data);
		$this->load->view('templates/footer');
	}
	
	function alipay(){
		$data['payment_gateway'] = 'alipay';
		$data['alipay_url'] = "alipay.com";//$this->paypal_lib->paypal_url
		$this->load->view('templates/header', $data);
		$this->load->view("pages/product", $data);
		$this->load->view('templates/footer');
	}

	function auto_form()
	{
		$this->paypal_lib->add_field('business', 'PAYPAL@EMAIL.COM');
	    $this->paypal_lib->add_field('return', site_url('paypal/success'));
	    $this->paypal_lib->add_field('cancel_return', site_url('paypal/cancel'));
	    $this->paypal_lib->add_field('notify_url', site_url('paypal/ipn')); // <-- IPN url
	    $this->paypal_lib->add_field('custom', '1234567890'); // <-- Verify return

	    $this->paypal_lib->add_field('item_name', 'Paypal Test Transaction');
	    $this->paypal_lib->add_field('item_number', '6941');
	    $this->paypal_lib->add_field('amount', '197');

	    $this->paypal_lib->paypal_auto_form();
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

		$data['pp_info'] = $this->input->post();
		$this->load->view('paypal/success', $data);
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
		$to    = 'YOUR@EMAIL.COM';    //  your email

		if ($this->paypal_lib->validate_ipn()) 
		{
			$body  = 'An instant payment notification was successfully received from ';
			$body .= $this->paypal_lib->ipn_data['payer_email'] . ' on '.date('m/d/Y') . ' at ' . date('g:i A') . "\n\n";
			$body .= " Details:\n";

			foreach ($this->paypal_lib->ipn_data as $key=>$value)
				$body .= "\n$key: $value";
	
			// load email lib and email results
			$this->load->library('email');
			$this->email->to($to);
			$this->email->from($this->paypal_lib->ipn_data['payer_email'], $this->paypal_lib->ipn_data['payer_name']);
			$this->email->subject('CI paypal_lib IPN (Received Payment)');
			$this->email->message($body);	
			$this->email->send();
		}
	}
}
?>