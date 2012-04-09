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
	
	public function load_products_to_web_store( $date_barrier = '2011-01-01 00:00:00' ){
		$product = 'erp.dbo.tbl_pos_item_mstr';
		$price = 'erp.dbo.tbl_pos_item_price';
		
		$this->lna_pos = $this->load->database('lna_pos', TRUE); // Load the db, and assign to the member var.
		
		$this->lna_pos->select("$product.item_code, style_no, color_code, size_code, short_desc, status, $product.created_date, $price.selling_price")->from("$product, $price")->where("$product.item_code = $price.item_code AND $product.created_date > '$data_barier'")->order_by("$product.item_code", "asc");

		$query = $this->lna_pos->get();
		
		var_dump($query->num_rows());
		
		if ($query->num_rows() > 0) {
			$pos_products = $query->result_array();
			
			$this->load->database();
			$query1 = "INSERT INTO products (id, name, price, status) VALUES ( ?, ?, ?, ?) ON DUPLICATE KEY UPDATE id=id";
			$query2 = "INSERT INTO product_color (pro_id, color) VALUES ( ?, ?) ON DUPLICATE KEY UPDATE color=color";
			$i = 0;
			
			foreach( $pos_products as $product ){
				$this->db->query($query1, array($product['style_no'], $product['short_desc'], $product['selling_price'], $product['status']));
				$this->db->query($query2, array($product['style_no'], $product['color_code']));
				$i++;
			}
			echo "<p>$i row(s) inserted</p>";
			
			// Do we have 1 result, as we expected? Return it as an array.
			return $query->result_array();
		}
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

	public function logout(){
		$session_data = $this->session->all_userdata();
		$this->session->unset_userdata('is_login');
		$this->session->sess_destroy(); // session destroy with custom code!
		redirect('index');
	}
	
	public function is_login(){
		$session_data = $this->session->all_userdata();
		return isset($session_data['is_login']) && $session_data['is_login']===TRUE;
	}	
}