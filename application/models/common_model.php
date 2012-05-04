<?php
class Common_model extends CI_Model {
	var $lna_pos;
	public function __construct()	{
		parent::__construct();
		//$this->load->database();
	}
	
	public function test(){
		echo "connecting...";

		$this->lna_pos = $this->load->database('lna_pos', TRUE); // Load the db, and assign to the member var.
		$this->lna_pos->select('count(1)')->from('erp.dbo.tbl_staff_info');
 
        $query = $this->lna_pos->get();
        if ($query->num_rows() === 1) {
			// Do we have 1 result, as we expected? Return it as an array.
			return $query->row_array();
		}
		return FALSE;
	}
	
	public function load_color(){
		$this->lna_pos = $this->load->database('lna_pos', TRUE); // Load the db, and assign to the member var.

		$query = "SELECT color_code, short_name, e_full_name, c_full_name, status ";
		$query .= "FROM tbl_pos_color_mstr ";
		$query .= "ORDER BY short_name, color_code ";
		
		$query = $this->lna_pos->query( $query );
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return FALSE;
	}
	
	public function get_color_by_id($id = ''){
		if( $id == '' )
			return FALSE;

		$this->lna_pos = $this->load->database('lna_pos', TRUE);
		$query = "SELECT color_code, short_name AS name_zh, e_full_name AS name_en, c_full_name, status ";
		$query .= "FROM tbl_pos_color_mstr WHERE color_code = ?";
		if( is_array($id) ){
			for( $i = 1; $i < count($id); $i++){
				$query .= " OR color_code = ?";
			}
		}
		$result = $this->lna_pos->query( $query, $id );
		$result = $result->result_array();
		$colors = array();
		foreach( $result as $color ){
			$colors[$color['color_code']] = array();
			$colors[$color['color_code']]['name_en'] = $color['name_en'];
			$colors[$color['color_code']]['name_zh'] = $color['name_zh'];
		}
		return $colors;
	}
	
	/*********************
	* This function will return the stock of the product(s) which the products' barcode LIKE '[barcode]'
	* If barcode is not provided, this will return the stock of all the products
	*/
	public function check_stock($barcode = '%'){
		$tb_product = 'erp.dbo.tbl_pos_item_mstr';
		$tb_stock = 'erp.dbo.tbl_wh_stk_tx';
		
		$this->lna_pos = $this->load->database('lna_pos', TRUE); // Load the db, and assign to the member var.

		$query = "SELECT items.item_code, (SUM(CASE WHEN trans_type='A' OR trans_type='I' THEN trans_qty ELSE 0 END) - SUM(CASE WHEN trans_type <> 'A' AND trans_type <> 'I' THEN trans_qty ELSE 0 END)) AS 'sum' ";
		$query .= "FROM $tb_product items, $tb_stock stock ";
		$query .= "WHERE items.barcode_no = stock.barcode_no AND ISNULL(stock.rec_status, '') <> 'D' AND items.barcode_no LIKE ? ";
		$query .= "GROUP BY items.item_code ";
		$query .= "ORDER BY items.item_code ";

		$query = $this->lna_pos->query( $query, array($barcode) );
		//echo "<p>" . $this->lna_pos->last_query() . "</p>";
		//var_dump($query->num_rows());
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return FALSE;
	}
	
	/*********************
	* Load the product list from POS to web store, which is created after the date specified
	* If the date is not provided, all products will be loaded.
	*/
	public function load_products_to_web_store($date_filter = FALSE){
		$tb_product = 'erp.dbo.tbl_pos_item_mstr';
		$tb_price = 'erp.dbo.tbl_pos_item_price';
		
		$date_filter = '2011-01-01';
		
		$this->lna_pos = $this->load->database('lna_pos', TRUE); // Load the db, and assign to the member var.

		$query = "SELECT items.item_code, style_no, color_code, size_code, short_desc, items.created_date, price.selling_price ";
		$query .= "FROM $tb_product items, $tb_price price ";
		$query .= "WHERE items.item_code = price.item_code AND DATEDIFF(DAY, CONVERT(DATETIME, ?, 103), items.created_date) >= 0 ";
		$query .= "ORDER BY items.item_code ";

		$query = $this->lna_pos->query( $query, array($date_filter) );
		
		if ($query->num_rows() > 0) {
			$pos_products = $query->result_array();
			
			$this->load->database();
			$query1 = "INSERT INTO products (id, name_zh, front_img, price, discount, status) VALUES ( ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE id=id";
			$query2 = "INSERT INTO product_color_size (pro_id, color, size) VALUES ( ?, ?, ?) ON DUPLICATE KEY UPDATE size=size";
			//$i = 0;
			
			foreach( $pos_products as $product ){
				$this->db->query($query1, array($product['style_no'], $product['short_desc'], $product['style_no'] . $product['color_code'] . '-F_s.jpg', $product['selling_price'], $product['selling_price'], 'N'));
				$this->db->query($query2, array($product['style_no'], $product['color_code'], $product['size_code']));
				//$i++;
			}
			//echo "<p>$i record(s) loaded</p>";
		
			return $query->result_array();
		}
		return FALSE;
	}
	
	public function get_product_list( $where = "created_date > '2012-02-01 00:00:00'" ) {
		$product = 'erp.dbo.tbl_pos_item_mstr';
		$price = 'erp.dbo.tbl_pos_item_price';
		$stock = 'erp.dbo.tbl_wh_stk_tx';
		
		$this->lna_pos = $this->load->database('lna_pos', TRUE); // Load the db, and assign to the member var.		
		
		$this->lna_pos->select("$product.item_code, $product.barcode_no, style_no, color_code, size_code, short_desc, status, $product.created_date, $price.*")->from("$product, $price")->where("$product.item_code = $price.item_code")->order_by("$product.created_date", "desc")->limit(0, 30);

		$query = $this->lna_pos->get();
		var_dump($query->num_rows());
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return FALSE;
	}

	public function _generate_random_string($len=8){
		$arr = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHI012345JKLMNOP0QRSTUVWXYZ6789'); // get all the characters into an array
		shuffle($arr); // randomize the array
		$arr = array_slice($arr, 0, $len); // get the first eight (random) characters out
		$str = implode('', $arr); // smush them back into a string
		return $str;
	}
}