<?php
class Menu_model extends CI_Model {

	public function __construct()	{
		$this->load->database();
	}
	
	public function get_menu() {
		$this->db->order_by("level", "asc");
		$this->db->join('categories', 'categories.id = navigations.cat_id', 'right');
		$this->db->select('categories.name, categories.id, navigations.cat_id, navigations.text_en, navigations.text_zh, navigations.text_cn, navigations.level');
		$query = $this->db->get('navigations');
		return $query->result_array();
	}
	
	public function get_submenu($level = '') {
		$this->db->order_by("level", "asc");
		$this->db->join('categories', 'categories.id = navigations.cat_id', 'right');
		$this->db->select('categories.name, categories.id, navigations.cat_id, navigations.text_en, navigations.text_zh, navigations.text_cn, navigations.level');
		$this->db->where("level like '${level}%'");
		$query = $this->db->get('navigations');
		$result = $query->result_array();

		$temp = array();
		$temp[$result[0]['level']] = $result[0]['text_en'];
		$result[0]['c_path'] = $result[0]['text_en'];
		for( $i = 1; $i < count($result); $i++){
			$mi = $result[$i];
			$temp[$mi['level']] = $temp[substr( $mi['level'], 0, strrpos($mi['level'], '.' ) )] . '/' . $mi['text_en'];
			$result[$i]['c_path'] = $temp[$mi['level']];
		}
		return $result;
	}
	
	public function get_menu_item($id = "") {
		if ($id === "") {
			return FALSE;
		}
		
		$query = $this->db->get_where('navigations', array('cat_id' => $id));
		return $query->row_array();
	}
	
	public function add_menu_item($menu = FALSE) {
		if( $menu == FALSE || $menu['cat_id'] == '' || $menu['text_en'] == '' )
			return FALSE;

		$this->db->insert('navigations', $menu);
		return $menu;
	}
	
	public function edit_menu_item($menu = FALSE) {
		if( $menu == FALSE || $menu['cat_id'] == '' || $menu['text_en'] == '' )
			return FALSE;

		$this->db->where('cat_id', $menu['cat_id']);
		return $this->db->update('navigations', $menu);
	}
}

?>