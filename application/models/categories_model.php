<?php
class Categories_model extends CI_Model {

	public function __construct()	{
		$this->load->database();
	}
	
	public function get_categories($id = "") {
		if ($id === "") {
			$query = $this->db->get('categories');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('categories', array('id' => $id));
		return $query->row_array();
	}
	
	public function get_categories_by_parent($id = NULL) {
		$query = $this->db->get_where('categories', array('parent' => $id));
		return $query->result_array();
	}
	
	public function get_category_parent($id = NULL) {
		if( $id === NULL )
			return NULL;
		$query = $this->db->get_where('categories', array('id' => $id));
		return $query->row_array();
	}
}

?>