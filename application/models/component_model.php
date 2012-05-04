<?php

class Component_model extends CI_Model {

	public function __construct()	{
		$this->load->database();
	}
	
	public function add_component($id = '', $name_en = '', $name_zh = ''){
		if( $id == '' || $name_en == '' || $name_zh == '' )
			return FALSE;

		try{
			$query = "INSERT INTO components VALUES(?, ?, ?)";
			return $this->db->query( $query, array( $id, $name_en, $name_zh ) );
		}catch(Exception $e){
			echo $e->get_message();
			return FALSE;
		}
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
	
	public function get_components($id = ''){
		if( $id == '' ){
			$query = "SELECT * FROM components";
			$result = $this->db->query($query);
			return $result->result_array();
		}
		$query = "SELECT * FROM components WHERE id = ?";
		$result = $this->db->query($query, $id);
		return $result->result_array();
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
	
	public function edit_component($id = '', $name_en = FALSE, $name_zh = FALSE){
		if( $id == '' || $name_en === FALSE || $name_zh === FALSE )
			return FALSE;

		try{
			$query = "UPDATE components SET name_en = ?, name_zh = ? WHERE id = ?";
			$this->db->query( $query, array( $name_en, $name_zh, $id ) );
			return TRUE;
		}catch(Exception $e){
			echo $e->get_message();
			return FALSE;
		}
	}
}
?>