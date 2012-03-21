<?php
class Category_model extends CI_Model {

	public function __construct()	{
		$this->load->database();
	}
	
	public function get_categories($id = "") {
		if ($id === "") {
			$this->db->order_by("name", "asc"); 
			$query = $this->db->get('categories');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('categories', array('id' => $id));
		return $query->row_array();
	}
		
	public function add_category($cat = "", $path = "") {
		if( $cat == "" )
			return FALSE;
		
		$now = date( 'Y-m-d H:i:s', time() );
		$category['name'] = $cat;
		$category['path'] = $path;
		$category['created_time'] = $now;
		$category['modified_time'] = $now;
		$this->db->insert('categories', $category);
		return $category;
	}
	
	public function edit_category($catid = '', $data = '') {
		if( $catid == '' || $data == '' )
			return FALSE;
		
		$now = date( 'Y-m-d H:i:s', time() );
		$category['modified_time'] = $now;
		foreach( $data as $key => $value )
			$category[$key] = $value;

		$this->db->where('id', $catid);
		return $this->db->update('categories', $category);
	}
}

?>