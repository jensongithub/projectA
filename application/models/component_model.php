<?php

class Component_model extends CI_Model {

	public function __construct()	{
		$this->load->database();
	}
	
	public function search_by_name($needle = ''){
		$needle = "%$needle%";
		$query = "SELECT * FROM components WHERE name_en LIKE ? OR name_zh LIKE ?";
		$result = $this->db->query( $query, array( $needle, $needle ) );
		$arr = $result->result_array();
		$result = array();
		foreach( $arr as $key => $val ){
			$result["c$key"] = $val;
		}
		return $result;
	}
	
	public function get_components_by_id($id = ''){
		$query = "SELECT * FROM components WHERE id = ?";
		$this->db->query($query, $id);
	}
	
	public function get_components_from_json($json = null){
		if( count($json) == 0 )
			return FALSE;

		$ret = array();
		foreach( $json as $key => $val ){
			$query = "SELECT * FROM components WHERE id = ?";
			$result = $this->db->query($query, $key);
			$ret[$key] = $result->row_array();
			unset($ret[$key]['id']);
			$ret[$key]['percentage'] = $val;
		}
		
		return $ret;
	}
}
?>