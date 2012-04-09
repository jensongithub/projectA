<?php
class Product_model extends CI_Model {

	public function __construct()	{
		$this->load->database();
	}
	
	public function get_products() {
		//$result = $this->db->query("SELECT products.*, categories.id AS cat_id, categories.name AS cat_name, categories.path FROM products, product_category, categories WHERE products.id = product_category.pro_id AND product_category.cat_id=categories.id ORDER BY priority DESC, created_time DESC");
		$result = $this->db->query("SELECT products.*, categories.id AS cat_id, categories.name AS cat_name, categories.path FROM products LEFT JOIN (product_category, categories) ON (products.id = product_category.pro_id AND product_category.cat_id=categories.id) ORDER BY priority DESC, created_time DESC");
		return $result->result_array();
	}
	
	public function get_products_in_category( $cid = '', $order_by = "priority DESC, created_time DESC") {
		$this->db->select("products.*")->from("products, product_category")->where("products.id = product_category.pro_id AND product_category.cat_id = $cid")->order_by($order_by);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function get_products_color( $pid = '' ) {
		$this->db->select("product_color.color")->from("products, product_color")->where("products.id = '$pid' AND products.id = product_color.pro_id");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	public function move_product_to_cat( $pid = '', $cid = '' ) {
		if( $pid == '' || $cid == '' )
			return FALSE;
		
		$query = "SELECT cat_id FROM product_category WHERE pro_id = ?";
		$result = $this->db->query($query, array($pid));
		if ($result->num_rows() > 0) {
			$query = "UPDATE product_category SET cat_id = ? WHERE pro_id = ?";
			$this->db->query($query, array($cid, $pid));
		}
		else{
			$query = "INSERT INTO product_category (pro_id, cat_id) VALUES ( ?, ?)";
			$this->db->query($query, array($pid, $cid));
		}
		return TRUE;
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
}

?>