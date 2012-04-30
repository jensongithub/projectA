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
	
	function Paypal_Lib()
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
		$API_Password="	1334808972";
		$API_Signature="AGwSDTMAsMrQNVF8WepyRCBqikHNAw.RM-FlCzuBUukX-vUjb-IsXuiE ";

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

	function paypal_auto_form() 
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
	}
	
	public function validate_ipn(){
		// read the post from paypal and add 'cmd'
		$is_valid = FALSE;

	    $req = 'cmd=_notify-validate';  
		foreach ($_POST as $key => $value) {  
		$value = urlencode(stripslashes($value));  
		$req .= "&$key=$value";  
		}  
		// post back to PayPal system to validate  
		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";  
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";  
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";  
		  
		$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
		//$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
		  
		if (!$fp) {  
			// HTTP ERROR  
		} else {
			fputs ($fp, $header . $req);  
			while (!feof($fp)) {
				$res = fgets ($fp, 1024); 
			
				$this->log_results($res);
				if (preg_match("/VERIFIED/i", $res)){
					// PAYMENT VALIDATED & VERIFIED!					
					$this->log_results("OKOK".$res);
					$is_valid = TRUE;
				}	  
				else if (preg_match("/INVALID/i", $res)){
					// PAYMENT INVALID & INVESTIGATE MANUALY!  
					$this->log_results("FAIL".$res);
				}

			}
		}
		fclose ($fp);
		return $is_valid;
	}
	
	
	function log_results($data) 
	{
		if (!$this->ipn_log) return;  // is logging turned off?

		/*
		// Timestamp
		$text = '['.date('m/d/Y g:i A').'] - '; 

		// Success or failure being logged?
		if ($success) $text .= "SUCCESS!\n";
		else $text .= 'FAIL: '.$this->last_error."\n";

		// Log the POST variables
		$text .= "IPN POST Vars from Paypal:\n";
		foreach ($this->ipn_data as $key=>$value)
			$text .= "$key=$value, ";

		// Log the response from the paypal server
		$text .= "\nIPN Response from Paypal Server:\n ".$this->ipn_response;

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
		if ($success) $text .= "SUCCESS!\n";
		else $text .= 'FAIL: '.$this->last_error."\n";

		// Log the POST variables
		$text .= "IPN POST Vars from Paypal:\n";
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