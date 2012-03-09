<?php
class Product_model extends CI_Model {

	public function __construct()	{
		$this->load->database();
	}
	
	public function get_menu() {
		$this->db->order_by("level", "asc");
		$this->db->join('categories', 'categories.id = navigations.cat_id', 'right');
		$this->db->select('categories.name, categories.id, navigations.cat_id, navigations.text, navigations.path, navigations.level');
		$query = $this->db->get('navigations');
		return $query->result_array();
	}
	
	public function get_menu_item($id = "") {
		if ($id === "") {
			return FALSE;
		}
		
		$query = $this->db->get_where('navigations', array('cat_id' => $id));
		return $query->row_array();
	}
	
	public function add_product_in_excel_sheets($sheets = FALSE) {
		if( $sheets == FALSE )
			return FALSE;

		foreach( $sheets as $key => $sheet){
			echo "<br/>";
			echo $sheets[$key]['name'] . ": ";
			echo "<br/>";
			for ($i = 1; $i <= $sheets[$key]['numRows']; $i++) {
				echo "Line $i: {";
				for ($j = 1; $j <= $sheets[$key]['numCols']; $j++) {
					if( isset($sheets[$key]['cells'][$i]) && isset($sheets[$key]['cells'][$i][$j]) )
						echo "\"".iconv("big5", "utf-8", $sheets[$key]['cells'][$i][$j])."\", ";
					else
						echo "\"\", ";
				}
				echo "}<br />\n";
			}
			echo "<br/>";
		}
		return 0;
	}
	
	public function edit_menu_item($menu = FALSE) {
		if( $menu == FALSE || $menu['cat_id'] == '' || $menu['text'] == '' )
			return FALSE;

		$this->db->where('cat_id', $menu['cat_id']);
		return $this->db->update('navigations', $menu);
	}
}

?>