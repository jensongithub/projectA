<?php
class Order_model extends CI_Model {
	var $CI;
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->CI =& get_instance();
	}
	

	public function update_paypal_order($uuid) {
		// update the temporary order to complete order
		$query = "update orders set txn_id = ?, status = ?, payment_date=? where rand_key = ? ";
		$result = $this->db->query($query, array($_POST['txn_id'], $_POST['payment_status'], $_POST['payment_date'], $uuid));
		
		$query = "update order_items set txn_id = ?, status = ? where rand_key = ? and txn_id is null";
		$result = $this->db->query($query, array($_POST['txn_id'], $_POST['payment_status'], $uuid));
	}
	
	function insert_checkout_item($checkout_items){
		// this is a temporary order
		$total_payment = 0;
		$affected_rows = 0;
	
		/*
		$product_details = $this->CI->product_model->get_cart_item_price($checkout_items);
		foreach($product_details as $key=>$each_item){
			foreach ($product_details as $each_product){
				if ($each_product['id'] === $each_item['id']){
					$checkout_items[$key]['price'] = $each_product['price'];
					$checkout_items[$key]['discount'] = $each_product['discount'];
				}
			}
		}*/
		
		$query = "select UUID() as uuid";
		$query = $this->db->query($query);
		list($ord_id) = $query->result_array();
		
		foreach($checkout_items as $key=>$each_item){
			$item_num = $key+1;
			$query = "insert into order_items(rand_key, prod_id, price, quantity, color, size) values(?,?,?,?,?,?)";
			$result = $this->db->query($query, array($ord_id['uuid'], $each_item['id'], $each_item['price'], $each_item['quantity'], $each_item['color'], $each_item['size']));			
			$total_payment += $each_item['price']*$each_item['quantity'];
			$affected_rows += count($this->db->affected_rows());
		}
		
		$query = "insert into orders(rand_key, price, created_date, modified_date, status) values(?, ?, NOW(), NOW(), 'pending')";
		$result = $this->db->query($query, array($ord_id['uuid'], $total_payment));
		
		return $ord_id['uuid'];
	}	
}
