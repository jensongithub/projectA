<?php
class Order_model extends CI_Model {
	var $CI;
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->CI =& get_instance();
	}
	

	public function update_paypal_order() {
		// update the temporary order to complete order
		$timestamp = strtotime($_POST['payment_date']);
		$payment_date = date("Y-m-d H:i:s",$timestamp);
		
		$query = "update orders set txn_id = ?, status = ?, payment_date=?, modified_date = ? where rand_key = ? and user_id = ? and id = ?";
		
		$result = $this->db->query($query, array($_POST['txn_id'], $_POST['payment_status'], $payment_date, $payment_date, $_POST['invoice'], $_POST['custom'], $_POST['parent_txn_id']));
		
		$query = "update orders_items set txn_id = ?, total_amount = ? where rand_key = ? and txn_id is null and order_id = ?";
		$result = $this->db->query($query, array($_POST['txn_id'], $_POST['mc_gross'], $_POST['invoice'], $_POST['parent_txn_id']));
	}
	
	function insert_checkout_item($data){
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
		list($rand_key) = $query->result_array();
		$rand_key = $rand_key['uuid'];
		
		$checkout_items = &$data['cart'];
		$user = &$data['user'];
		
		/*$timestamp = strtotime($_POST['payment_date']);
		$payment_date = date("Y-m-d H:i:s",$timestamp);
		*/
				
		$query = "insert into orders(user_id, rand_key, status, created_date, modified_date) values(?, ?, ?, NOW(), NOW())";
		$result = $this->db->query($query, array($user['id'], $rand_key, 'pending'));
		
		$query = "select id as order_id from orders where rand_key = ?";
		$query = $this->db->query($query, array($rand_key));
		list($order) = $query->result_array();
		$order_id = $order['order_id'];
		
		foreach($checkout_items as $key=>$each_item){
			//$item_num = $key+1;
			$query = "insert into orders_items(order_id, rand_key, prod_id, price, quantity, color, size) values(?,?,?,?,?,?,?)";
			$result = $this->db->query($query, array($order_id, $rand_key, $each_item['id'], $each_item['price'], $each_item['quantity'], $each_item['color'], $each_item['size']));
			$total_payment += $each_item['discount']*$each_item['quantity'];
			$affected_rows += count($this->db->affected_rows());
		}
		
//		$affected_rows += count($this->db->affected_rows());
		
		return array("rand_key"=>$rand_key, "order_id"=>$order_id);
	}	
}
