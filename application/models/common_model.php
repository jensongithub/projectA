<?php
class Common_model extends CI_Model {
	var $lna_pos;
	public function __construct()	{
		parent::__construct();
		//$this->load->database();
	}
	
	public function test(){
		echo "connecting...";

		$this->lna_pos = $this->load->database('lna_pos', TRUE); // Load the db, and assign to the member var.
		$this->lna_pos->select('count(1)')->from('erp.dbo.tbl_staff_info');
 
        $query = $this->lna_pos->get();
        if ($query->num_rows() === 1) {
			// Do we have 1 result, as we expected? Return it as an array.
			return $query->row_array();
		}
		return FALSE;
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