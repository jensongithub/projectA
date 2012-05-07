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
		$timestamp = strtotime($this->CI->input->post('payment_date'));
		$payment_date = date("Y-m-d H:i:s",$timestamp);
		
		
		// custom is the user id in the production database
		//$this->CI->input->post('custom')
		
		// parent_txn_id is the order id 
		//$this->CI->input->post('parent_txn_id')
		
		//$this->CI->input->post('invoice') is the rand_key
		
		$query = "insert into order_address(order_id, user_id, country, country_code, address_zip, address_state, address_city, address_street, created_date, modified_date) values(?, ?, ?, ?,?,?,?,?,NOW(), NOW())";
		$result = $this->db->query($query, array($this->CI->input->post('parent_txn_id'), $this->CI->input->post('custom'), $this->CI->input->post('address_country'), $this->CI->input->post('address_country_code'), $this->CI->input->post('address_zip'), $this->CI->input->post('address_state'), $this->CI->input->post('address_city'), $this->CI->input->post('address_street')));

		$query = "update orders set txn_id = ?, total_amount=?, status = ?, payment_date=?, modified_date = ? where rand_key = ? and user_id = ? and id = ?";
		$result = $this->db->query($query, array($this->CI->input->post('txn_id'), $this->CI->input->post('mc_gross'), $this->CI->input->post('payment_status'), $payment_date, $payment_date, $this->CI->input->post('invoice'), $this->CI->input->post('custom'), $this->CI->input->post('parent_txn_id')));
		
		$query = "update orders_items set txn_id = ?, modified_date = NOW() where rand_key = ? and order_id = ?";
		$result = $this->db->query($query, array($this->CI->input->post('txn_id'), $this->CI->input->post('invoice'), $this->CI->input->post('parent_txn_id')));
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
	
	function get_order_by_status($condition, $rownum, $howmany){
		$condition_str = '';		
		foreach ($condition as $key=>$val){			
			//$val = $each_cond[$key];
			$condition_str .= " and $key = '$val' ";
		}
		
		$query = "select users.firstname, users.lastname, users.email, users.phone, order_address.*, orders.* 
					from orders, users, order_address 
					where orders.user_id = users.id and orders.id = order_address.order_id and orders.status='Completed' $condition_str limit ?, ?";
		$query = $this->db->query($query, array( $rownum, $howmany) );
		
		return $query->result_array();
	}
	
	function get_order_items_by_order_id($order_id){
		
		//SELECT cat.* FROM products pro, categories cat, product_category pc WHERE pro.id = pc.pro_id AND cat.id = pc.cat_id AND pro.id = ?
		
		//return json_encode($query->result_array(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_FORCE_OBJECT);
	}
	
	function set_order_is_handed($order_id, $is_handled, $user_id){
		$query = "update orders set is_handled = ?, handle_by = ?, modified_date = NOW() where id = $order_id";
		$result = $this->db->query($query, array($is_handled, $user_id));
		
		return $this->db->affected_rows(); 
	}
}
