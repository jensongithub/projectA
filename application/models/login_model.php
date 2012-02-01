<?php
// developer only change the model for every new project
//include_once APPPATH.'libraries/loginLib.php';

class Login_Model extends CI_Model{
	protected $CI;
	var $id;
	var $email;

	function __construct(){
		parent::__construct();
		$this->load->database();
		$dataRules = array();
//		$dataRules["first_name"] = "XSS_CLEAN|TRIM|...";
//		$dataRules["last_name"] = "XSS_CLEAN|TRIM|...";
//		$dataRules["email"] = "XSS_CLEAN|TRIM|isEmail";

//		$this->dataRules = &$dataRules;
		$validUserSQL = "select firstname, lastname, pwd from users where username = ? ";
	}

	function submit(){
		$this->insert_user();
	}

	function insert_user(){
		$uid = mt_srand(time());
		echo $uid;
		$this->id = $uid;
		$this->email = 'davidrobinson91@hotmail.com';
		$this->db->insert('user',$this);

	}
}
