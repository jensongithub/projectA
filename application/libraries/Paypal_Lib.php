<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, pMachine, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * PayPal_Lib Controller Class (Paypal IPN Class)
 *
 * This CI library is based on the Paypal PHP class by Micah Carrick
 * See www.micahcarrick.com for the most recent version of this class
 * along with any applicable sample files and other documentaion.
 *
 * This file provides a neat and simple method to interface with paypal and
 * The paypal Instant Payment Notification (IPN) interface.  This file is
 * NOT intended to make the paypal integration "plug 'n' play". It still
 * requires the developer (that should be you) to understand the paypal
 * process and know the variables you want/need to pass to paypal to
 * achieve what you want.  
 *
 * This class handles the submission of an order to paypal as well as the
 * processing an Instant Payment Notification.
 * This class enables you to mark points and calculate the time difference
 * between them.  Memory consumption can also be displayed.
 *
 * The class requires the use of the PayPal_Lib config file.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Commerce
 * @author      Ran Aroussi <ran@aroussi.com>
 * @copyright   Copyright (c) 2006, http://aroussi.com/ci/
 *
 */

// ------------------------------------------------------------------------

class Paypal_Lib {

	var $last_error;			// holds the last error encountered
	var $ipn_log;				// bool: log IPN results to text file?

	var $ipn_log_file;			// filename of the IPN log
	var $ipn_response;			// holds the IPN response from paypal	
	var $ipn_data = array();	// array contains the POST values for IPN
	var $fields = array();		// array holds the fields to submit to paypal

	var $submit_btn = '';		// Image/Form button
	var $button_path = '';		// The path of the buttons
	var $paypal_url= '';
	var $SandboxFlag =true;
	var $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->helper('form');
		$this->CI->load->config('paypallib_config');
		
		
		//'------------------------------------
		//' PayPal API Credentials
		//' Replace <API_USERNAME> with your API Username
		//' Replace <API_PASSWORD> with your API Password
		//' Replace <API_SIGNATURE> with your Signature
		//'------------------------------------
		$API_UserName="jendro_1334808935_biz_api1.gmail.com";
		$API_Password="1334808972";
		$API_Signature="AGwSDTMAsMrQNVF8WepyRCBqikHNAw.RM-FlCzuBUukX-vUjb-IsXuiE";

		// BN Code 	is only applicable for partners
		$sBNCode = "PP-ECWizard";
		
		
		/*	
		' Define the PayPal Redirect URLs.  
		' 	This is the URL that the buyer is first sent to do authorize payment with their paypal account
		' 	change the URL depending if you are testing on the sandbox or the live PayPal site
		'
		' For the sandbox, the URL is       https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=
		' For the live site, the URL is        https://www.paypal.com/webscr&cmd=_express-checkout&token=
		*/
		
		if ($this->SandboxFlag == true) 
		{
			$API_Endpoint = "https://api-3t.sandbox.paypal.com/nvp";
			//$PAYPAL_URL = "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=";
			$PAYPAL_URL = "https://www.sandbox.paypal.com/webscr";
		}
		else
		{
			$API_Endpoint = "https://api-3t.paypal.com/nvp";
			//$PAYPAL_URL = "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
			$PAYPAL_URL = "https://www.paypal.com/cgi-bin/webscr";
		}
		
		//$this->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
		
		$this->paypal_url = $PAYPAL_URL;

		$this->last_error = '';
		$this->ipn_response = '';

		$this->ipn_log_file = $this->CI->config->item('paypal_lib_ipn_log_file');
		$this->ipn_log = $this->CI->config->item('paypal_lib_ipn_log');
	}

	function button($value)
	{
		// changes the default caption of the submit button
		$this->submit_btn = form_submit('pp_submit', $value);
	}

	function image($file)
	{
		$this->submit_btn = '<input type="image" name="add" src="' . site_url($this->button_path .'/'. $file) . '" border="0" />';
	}


	function add_field($field, $value) 
	{
		// adds a key=>value pair to the fields array, which is what will be 
		// sent to paypal as POST variables.  If the value is already in the 
		// array, it will be overwritten.
		$this->fields[$field] = $value;
	}

	/*function paypal_auto_form() 
	{
		// this function actually generates an entire HTML page consisting of
		// a form with hidden elements which is submitted to paypal via the 
		// BODY element's onLoad attribute.  We do this so that you can validate
		// any POST vars from you custom form before submitting to paypal.  So 
		// basically, you'll have your own form which is submitted to your script
		// to validate the data, which in turn calls this function to create
		// another hidden form and submit to paypal.

		$this->button('Click here if you\'re not automatically redirected...');

		echo '<html>' . "\n";
		echo '<head><title>Processing Payment...</title></head>' . "\n";
		echo '<body onLoad="document.forms[\'paypal_auto_form\'].submit();">' . "\n";
		echo '<p>Please wait, your order is being processed and you will be redirected to the paypal website.</p>' . "\n";
		echo $this->paypal_form('paypal_auto_form');
		echo '</body></html>';
	}

	function paypal_form($form_name='paypal_form') 
	{
		$str = '';
		$str .= '<form method="post" action="'.$this->paypal_url.'" name="'.$form_name.'"/>' . "\n";
		foreach ($this->fields as $name => $value)
			$str .= form_hidden($name, $value) . "\n";
		$str .= '<p>'. $this->submit_btn . '</p>';
		$str .= form_close() . "\n";

		return $str;
	}*/
	
	function build_form($data){
		$paypal_id = $this->CI->config->item('paypal_id');
		
		$html = <<<PAYPAL_FORM
		<form action="{$this->paypal_url}" METHOD='POST' name="order_form">
			<input type="hidden" name="cmd" value="_cart" />
			<input type="hidden" name="upload" value="1" />
			<input type="hidden" name="business" value="$paypal_id" />
PAYPAL_FORM;
		$item_num=1;
		//<input type="hidden" name="item_name_$item_num" value="{$each_item['name_'.$data['page']['lang']]}" />
		foreach($data['cart'] as $each_item){
			$html.=<<<PAYPAL_FORM
			<input type="hidden" name="item_name_$item_num" value="{$each_item['id']}" /> 
			<input type="hidden" name="item_number_$item_num" value="{$each_item['id']}" />
			<input type="hidden" name="amount_$item_num" value="{$each_item['price']}" />
			<input type="hidden" name="quantity_$item_num" value="{$each_item['quantity']}" />
PAYPAL_FORM;
			++$item_num;
		}
		
		$success_url = site_url().$this->CI->lang->lang()."/checkout/success";
		$cancel_url = site_url().$this->CI->lang->lang()."/checkout/cancel";
		$notify_url = site_url().$this->CI->lang->lang()."/checkout/paypal_ipn";
		$currency = $this->CI->config->item('paypal_lib_currency_code');
		
		$html.=<<<PAYPAL_FORM
			<input type="hidden" name="currency_code" value="$currency">
			<input type="hidden" name="lc" value="HK">
			<input type="hidden" name="rm" value="2">
			<input type="hidden" name="shipping" value="{$data['page']['delivery_charge']}">
			<input type="hidden" name="shipping_2" value="0">
			<input type="hidden" name="return" value="{$success_url}">
			<input type="hidden" name="cancel_return" value="{$cancel_url}">
			<input type="hidden" name="notify_url" value="{$notify_url}">
			<input type="hidden" name="invoice" value="{$data['page']['order_id']}">
			<input type="hidden" name="custom" value="{$data['user']['id']}">
			<input type="hidden" name="charset" value="utf-8">
		</form>
		<script>document.order_form.submit();</script>
PAYPAL_FORM;
		return $html;
		//<input type="hidden" name="parent_txn_id" value="{$data['page']['order_id']}">
		//<input type="hidden" name="pg" value="paypal_submit">
	}
	
	function _validate_ipn(){
		// read the post from paypal and add 'cmd'
		$is_valid = FALSE;
	
		$test=TRUE;
		// Choose url
		if($test)
			$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		else
			$url = 'https://www.paypal.com/cgi-bin/webscr';
	
		// Set up request to PayPal
		$request = curl_init();
		curl_setopt_array($request, array
		(
			CURLOPT_URL => $url,
			CURLOPT_POST => TRUE,
			CURLOPT_VERBOSE => TRUE,
			CURLOPT_POSTFIELDS => http_build_query(array_merge(array('cmd' => '_notify-validate'), $_POST)),
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_HEADER => FALSE,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_SSL_VERIFYHOST => FALSE
			/*, 
			,CURLOPT_CAINFO => 'cacert.pem',
			*/
		));
		
		// Execute request and get response and status code
		$response = curl_exec($request);
		$status   = curl_getinfo($request, CURLINFO_HTTP_CODE);

		// Close connection
		curl_close($request);

		if($status == 200 && $response == 'VERIFIED')
		{
			
			$this->log_results($status.":".$response.":". http_build_query(array('cmd' => '_notify-validate') + $_POST));
			$is_valid = TRUE; 
		}
		else
		{
			$this->log_results($status.":".$response.":". http_build_query(array('cmd' => '_notify-validate') + $_POST));
		}		
	    
		return $is_valid;
	}
	
	function validate_ipn()
	{
		// parse the paypal URL
		$url_parsed = parse_url($this->paypal_url);

		// generate the post string from the _POST vars aswell as load the
		// _POST vars into an arry so we can play with them from the calling
		// script.
		$post_string = '';
		if ($this->CI->input->post())
		{
			foreach ($this->CI->input->post() as $field=>$value)
			{ 
				$this->ipn_data[$field] = $value;
				//$post_string .= $field.'='.urlencode(stripslashes($value)).'&';
				$post_string .= $field.'='.$value.'&';
			}
		}
		
		$post_string.="cmd=_notify-validate"; // append ipn command

		// open the connection to paypal
		$fp = fsockopen("ssl://www.sandbox.paypal.com",443,$err_num,$err_str,30); 		
		if(!$fp)
		{ 
			// could not open the connection.  If loggin is on, the error message
			// will be in the log.
			$this->last_error = "fsockopen error no. $errnum: $errstr,".$url_parsed['host']; 
			$this->log_ipn_results(false);
			return false;
		} 
		else
		{
			// Post the data back to paypal
			$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
			//fputs($fp, "Host: $url_parsed[host]\r\n"); 
			$header .= "Content-type: application/x-www-form-urlencoded\r\n"; 
			$header .= "Content-length: ".strlen($post_string)."\r\n"; 
			$header .= "Connection: close\r\n\r\n"; 
			fputs($fp, $header . $post_string); 
			$this->log_results($post_string);
			// loop through the response from the server and append to variable
			while(!feof($fp)){
				$this->ipn_response = fgets($fp, 1024); 
			}

			fclose($fp); // close connection
		}

		if (strcmp ($this->ipn_response, "VERIFIED") == 0) 
		{
			// Valid IPN transaction.
			$this->log_ipn_results(true);
			return true;		 
		}
		else 
		{
			// Invalid IPN transaction.  Check the log for details.
			$this->last_error = 'IPN Validation Failed.';
			$this->log_ipn_results(false);	
			return false;
		}
	}
	
	function log_results($data) 
	{
		if (!$this->ipn_log) return;  // is logging turned off?

		// Write to log*/
		$fp=fopen($this->ipn_log_file,'a');
		fwrite($fp, $data . "\n\n"); 

		fclose($fp);  // close file
	}
	
	function log_ipn_results($success) 
	{
		if (!$this->ipn_log) return;  // is logging turned off?

		// Timestamp
		$text = '['.date('m/d/Y g:i A').'] - '; 

		// Success or failure being logged?
		if ($success) $text .= "SUEEEEECCESS!\n";
		else $text .= 'FAIL: '.$this->last_error."\n";

		// Log the POST variables
		$text .= "IPN POST vars from Paypal:\n";
		foreach ($this->ipn_data as $key=>$value)
			$text .= "$key=$value, ";

		// Log the response from the paypal server
		$text .= "\nIPN Response from Paypal Server:\n ".$this->ipn_response;

		// Write to log
		$fp=fopen($this->ipn_log_file,'a');
		fwrite($fp, $text . "\n\n"); 

		fclose($fp);  // close file
	}

	function dump() 
	{
		// Used for debugging, this function will output all the field/value pairs
		// that are currently defined in the instance of the class using the
		// add_field() function.

		ksort($this->fields);
		echo '<h2>ppal->dump() Output:</h2>' . "\n";
		echo '<code style="font: 12px Monaco, \'Courier New\', Verdana, Sans-serif;  background: #f9f9f9; border: 1px solid #D0D0D0; color: #002166; display: block; margin: 14px 0; padding: 12px 10px;">' . "\n";
		foreach ($this->fields as $key => $value) echo '<strong>'. $key .'</strong>:	'. urldecode($value) .'<br/>';
		echo "</code>\n";
	}

}

?>