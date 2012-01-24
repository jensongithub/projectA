<?php
// developer only change the model for every new project
include_once APPPATH.'libraries/loginLib.php';

abstract class MLogin extends LoginLib{
	public $CI;

	function __construct($username, $pwd){
		parent::__construct();
		$this->CI = & $this->getInstance();
		$this->CI->load->model("database");


		$dataRules = array();
		$dataRules["first_name"] = "XSS_CLEAN|TRIM|...";
		$dataRules["last_name"] = "XSS_CLEAN|TRIM|...";
		$dataRules["email"] = "XSS_CLEAN|TRIM|isEmail";

		$this->dataRules = &$dataRules;
		$validUserSQL = "select firstname, lastname, pwd from users where username = ? ";
	}
}


