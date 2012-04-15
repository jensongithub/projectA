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
	
	public function get_products_for_listing($dept = '', $cat = '', $sub = ''){
		$this->load->helper( 'file' );

		$q_dept = "SELECT * FROM products pro, product_category pc, categories cat, navigations nav WHERE pro.id = pc.pro_id AND pc.cat_id = cat.id AND cat.id = nav.cat_id AND text = ? ";
		$q_sub = "";
		
		$q_dept = "SELECT level FROM categories cat, navigations nav WHERE cat.id = nav.cat_id AND text = ? ";
		$q_cat = "SELECT nav.level FROM categories cat, navigations nav, ($q_dept) q_dept WHERE cat.id = nav.cat_id AND text = ? AND nav.level LIKE CONCAT(q_dept.level, '%') ";

		if( $sub != "" ){
			$q_sub = "SELECT cat.id FROM categories cat, navigations nav, ($q_cat) q_cat WHERE cat.id = nav.cat_id AND text = ? AND nav.level LIKE CONCAT(q_cat.level, '%') ";
		}
		else{
			$q_sub = "SELECT cat.id FROM categories cat, navigations nav, ($q_cat) q_cat WHERE cat.id = nav.cat_id AND nav.level LIKE CONCAT(q_cat.level, '%') ";
		}
		
		// real
		$q_pro = "SELECT pro.* FROM products pro, product_category pc WHERE pro.id = pc.pro_id AND pc.cat_id IN ($q_sub) ORDER BY id";
		$result = $this->db->query($q_pro, array($dept, $cat, $sub) );
		echo "<p><br/>" . $this->db->last_query() . "<br/></p>";
		
		$products = $result->result_array();
		
		foreach ($products as $key => $row) {
			$priority[$key]  = $row['priority'];
			$created_time[$key] = $row['created_time'];
		}
		array_multisort( $created_time, SORT_DESC, $priority, SORT_ASC, $products);
		
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

		$cols = array( '', 'id', 'price', 'discount', 'description_en', 'description_zh', 'priority', 'components', 'status');
		$success_count = 0;
		$fail_count = 0;
		$fail_log = array();
		
		foreach( $sheets as $key => $sheet){
			// for each row
			for ($i = 1; $i <= $sheet['numRows']; $i++) {
				if( !isset($sheet['cells'][$i]) || !isset($sheet['cells'][$i][1]) || strpos($sheet['cells'][$i][1], '#') === 0 || $sheet['cells'][$i][1] == '' )
					continue;

				$query = "UPDATE products SET "
				. "price = ?2, discount = ?3, description_en = ?4, description_zh = ?5, priority = ?6, components = ?7, status = ?8 "
				. "WHERE id = ?";
				$data = array();
				$style_code = $sheet['cells'][$i][1];
				
				// for each column
				for ($j = 2; $j <= 8; $j++) {
					if( ! isset($sheet['cells'][$i][$j]) || $sheet['cells'][$i][$j] == '' ){
						$query = str_replace( "?$j", $cols[$j], $query );
						continue;
					}
					else{
						if( $cols[$j] == "description_zh" )
							$data[] = iconv("big5", "utf-8", $sheet['cells'][$i][$j] );
						else if( $cols[$j] == "components" ){
							$com_list = array();
							$items = explode(",", $sheet['cells'][$i][$j]);
							foreach($items as $item){
								$t = explode(" ", preg_replace("(\s+)", " ", trim($item)) );
								$com_list[$t[0]] = $t[1];
							}
							$data[] = json_encode( $com_list );
						}
						else
							$data[] = $sheet['cells'][$i][$j];
					}
				}
				
				// fill in the id and prepare the update query
				//$data[] = $style_code;
				$data[] = 'A';
				$query = preg_replace( "(\?\d+)", "?", $query);

				$result = $this->db->query($query, $data);
				if( $result ) {
					$success_count++;
				}
				else{
					$fail_count++;
					$fail_log[] = $style_code;
				}
			}
		}
		
		// return an array to notify the result
		return array( "success" => $success_count, "fail" => $fail_count, "fail_log" => $fail_log );
	}
	
	public function handle_products_excel($upload_data = FALSE){
		if( ! is_array($upload_data) )
			return FALSE;

		// setup the excel reader
		$this->excel_reader_2_21->setOutputEncoding('CP950');
		$this->excel_reader_2_21->setStoreExtendedInfo(FALSE);
		
		$this->excel_reader_2_21->read( $upload_data['full_path'] );

		$sheets = $this->excel_reader_2_21->sheets;
		
		// add the sheet name to each sheet
		$ns = count( $sheets );
		for($i = 0; $i < $ns; $i++){
			$sheets[$i]['name'] = $this->excel_reader_2_21->boundsheets[$i]['name'];
		}
		
		return $this->product_model->add_product_in_excel_sheets( $sheets );
	}
}

?>