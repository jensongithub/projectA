<?php
class Common_model extends CI_Model {

	public function __construct()	{
		parent::__construct();
		//$this->load->database();
	}
	
	public function logout(){
		$session_data = $this->session->all_userdata();
		$this->session->unset_userdata('is_login');
		$this->session->sess_destroy(); // session destroy with custom code!
		redirect('index');
	}
	
	public function is_login(){
		$session_data = $this->session->all_userdata();
		return isset($session_data['is_login']) && $session_data['is_login']===TRUE;
	}	
}