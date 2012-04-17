<?php
if (! defined("BASEPATH") || ! defined("APPPATH")) exit("No direct script access allowed");

class MY_Email extends CI_Email {

	private $domain;

	public function __construct() {
		$config = array();
		$config["crlf"] = "\r\n";
		$config["newline"] = "\r\n";
		$config["mailtype"] = "text";
		$config["protocol"] = "smtp";
		
		$this->domain = "casimira.com.hk";
		$config["protocol"] = "smtp";
		$config["smtp_host"] = "mail." . $this->domain;
		$config["smtp_user"] = "info@" . $this->domain;
		$config["smtp_pass"] = "LNAcasimira888";
		$config['smtp_port'] = '25';
		$config['smtp_crypto'] = '';
		
		parent::__construct($config);
	}

	public function send_activate_mail($user, $subject, $message) {
		if ($user["id"] <= 0) {
			return false;
		}
		
		$to = $user["email"];

		$this->subject($subject);
		$this->message($message);
		
		$this->to($to);
		$this->from("info@" . $this->domain, $subject);
		$this->reply_to("info@" . $this->domain, $subject);
		
		$ok = $this->send();

		$this->clear(true);

		return $ok;
	}
	
	
	public function send_forgotten_pwd_mail($user, $subject, $message) {
		/**
		 * send a link for user to go to reset password page
		 **/
		if ($user["id"] <= 0) {
			return false;
		}
		
		$to = $user["email"];

		$this->subject($subject);
		$this->message($message);
		
		$this->to($to);
		$this->from("info@" . $this->domain, $subject);
		$this->reply_to("info@" . $this->domain, $subject);
		
		$ok = $this->send();

		$this->clear(true);

		return $ok;
	}
	
}