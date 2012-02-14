<?php

class MyLoginLib {
	var $CI;
	var $id;
	var $email;

	function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->database();
		$dataRules = array();
		$validUserSQL = "select firstname, lastname, pwd from users where username = ? ";
	}

	public function submit(){
		$this->insert_user();
	}

	public function insert_user(){
		$uid = mt_rand();
		$this->id = $uid;
		$this->email = 'davidrobinson91@hotmail.com';
		$this->CI->db->insert('user',$this);
	}
}
