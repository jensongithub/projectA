<?php
class Register_model extends CI_Model {

	public function __construct()	{
		$this->load->database();
	}
	
	public function get_user($id = "") {
		if ($id === "") {
			$query = $this->db->get('user');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('user', array('id' => $id));
		return $query->row_array();
	}
	
	public function insert_user() {		
		$user['firstname'] = $this->input->post('firstname');
		$user['lastname'] = $this->input->post('lastname');
		$user['email'] = $this->input->post('email');
		$user['phone'] = $this->input->post('phone');
		$user['gender'] = $this->input->post('gender');
		print_r($user);
		$query = $this->db->insert('tablename', $user);
	}
}

?>