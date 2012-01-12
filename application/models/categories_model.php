<?php
class Categories_model extends CI_Model {

	public function __construct()	{
		$this->load->database();
	}
	
	public function get_category($id = "") {
		if ($id === "") {
			$query = $this->db->get('categories');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('categories', array('id' => $id));
		return $query->row_array();
	}
}

?>