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
		
		// order id
		//$this->CI->input->post('invoice') is the orders.id 
		
		$query = "insert into order_address(order_id, user_id, country, country_code, address_zip, address_state, address_city, address_street, created_date, modified_date) values(?, ?, ?, ?,?,?,?,?,NOW(), NOW())";
		$result = $this->db->query($query, array($this->CI->input->post('invoice'), $this->CI->input->post('custom'), $this->CI->input->post('address_country'), $this->CI->input->post('address_country_code'), $this->CI->input->post('address_zip'), $this->CI->input->post('address_state'), $this->CI->input->post('address_city'), $this->CI->input->post('address_street')));

		$query = "update orders set txn_id = ?, total_amount=?, currency=?, status = ?, payment_date=?, modified_date = NOW() where id = ? and user_id = ?";
		$result = $this->db->query($query, array($this->CI->input->post('txn_id'), $this->CI->input->post('mc_gross'), $this->CI->input->post('mc_currency'), $this->CI->input->post('payment_status'), $payment_date, $this->CI->input->post('invoice'), $this->CI->input->post('custom')));
		
		$query = "update orders_items set txn_id = ?, modified_date = NOW() where order_id = ?";
		$result = $this->db->query($query, array($this->CI->input->post('txn_id'), $this->CI->input->post('invoice')));
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
	
	function get_order_by_status($conditions, $rownum='0', $howmany=15){
		$condition_str = '';
		foreach ($conditions as $key=>$val){
			//$val = $each_cond[$key];
			$condition_str .= " and $key = '$val' ";
		}
		
		$query = "select users.firstname, users.lastname, users.email, users.phone, order_address.*, orders.* 
					from orders, users, order_address 
					where orders.user_id = users.id and orders.id = order_address.order_id and orders.status='Completed' $condition_str limit $rownum, $howmany";
		$query = $this->db->query($query);
		
		return $query->result_array();
	}
	
	function get_order_count($conditions){
		$condition_str = '';
		foreach ($conditions as $key=>$val){
			//$val = $each_cond[$key];
			$condition_str .= " and $key = '$val' ";
		}
		
		$query = "select count(1) as cnt
					from orders, users, order_address 
					where orders.user_id = users.id and orders.id = order_address.order_id and orders.status='Completed' $condition_str";
		$query = $this->db->query($query);
		
		return $query->result_array();
	}
	
	function get_order_items_by_id($order_id){
		
		$query = "select categories.path, orders_items.order_id, orders_items.prod_id, orders_items.price, orders_items.quantity, orders_items.color, orders_items.size
		from orders_items, 
			orders, 
			categories, 
			product_category 
		where orders_items.order_id = orders.id 
		and orders.id = ?
		and orders_items.prod_id = product_category.pro_id
		and product_category.cat_id = categories.id";
		
		$query = $this->db->query($query, array($order_id) );
		
		return $query->result_array();
		//return json_encode($query->result_array(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_FORCE_OBJECT);
	}
	
	function set_order_is_handed($order_id, $username){
		$query = "update orders set is_handled = CASE WHEN is_handled = 0 THEN 1 WHEN is_handled = 1 THEN 0 END, handle_by = ?, handle_date = NOW() where id = ?";
		$result = $this->db->query($query, array($username, $order_id));
		
		return $this->db->affected_rows();
	}
	
	function get_orders_by_user_id($conditions, $rownum=0, $howmany=15){
		
		return $this->get_order_by_status($conditions, $rownum, $howmany);
	}
	
	function get_orders_cnt_by_user_id($conditions, $rownum=0, $howmany=15){
		
		return $this->get_order_count($conditions);
	}
	
	function get_orders_summary_by_status($conditions){
		
		
		
		/*
		$conditions = array();
		$conditions['report_year']='2012';
		$conditions['report_duration']='this_week';
		$conditions['report_category']='';
		*/
		
		$period_condition='';
		$grp_condition=array();
		$date_field = 'orders.payment_date';
		
		if (isset($conditions['report_year'])){
			$grp_condition[] = "Year({$conditions['report_year']})";
		}
		
		if (isset($conditions['report_duration'])){
			if ($conditions['report_duration']==='this_week'){
				$period_condition = "WEEK(orders.payment_date) period,";
				$grp_condition[] = "period HAVING period=WEEK(NOW())";
			}else if ($conditions['report_duration']==='weekly'){
				$period_condition = "WEEK(orders.payment_date) period,";
				$grp_condition[] = "WEEK($date_field)";
			}else if ($conditions['report_duration']==='monthly'){
				$period_condition = "MONTH(orders.payment_date) period,";
				$grp_condition[] = "MONTH($date_field)";
			}else if ($conditions['report_duration']==='quarterly'){
				$period_condition = "QUARTER(orders.payment_date) period,";
				$grp_condition[] = "QUARTER($date_field)";
			}else if ($conditions['report_duration']==='annually'){
				$period_condition = "YEAR(orders.payment_date) period,";
				$grp_condition[] = "YEAR($date_field)";
			}
		}
		
		$and_conditions = array();
		if (isset($conditions['report_category']) && $conditions['report_category']!=''){
			//$str = implode("', '", $conditions['report_category']);
			$str = $conditions['report_category'];
			$and_conditions[] = "and categories.name in ('$str')";
		}
		
		$and_condition_str = implode(" ", $and_conditions);
		
		$grp_condition_str = "GROUP BY ".implode(", ", $grp_condition);
		
		$query = "select $period_condition categories.name cat_name, sum(orders_items.price*orders_items.quantity) total_amount, sum(orders_items.quantity) qty, sum(products.cost) total_cost
			from orders_items, orders, categories, product_category, products
			where orders_items.order_id = orders.id 
			and products.id = product_category.pro_id 
			and orders_items.prod_id = product_category.pro_id 
			and product_category.cat_id = categories.id 
			and orders.status='Completed'
		$and_condition_str
		$grp_condition_str";
		
		$query = $this->db->query($query);
		
		return $query->result_array();
	}
	
}
