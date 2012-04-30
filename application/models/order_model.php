<?php
class Order_model extends CI_Model {

	public function __construct()	{
		$this->load->database();
	}
	
	// called only when ipn returns success
	public function insert_order($order) {
		//$result = $this->db->query("SELECT products.*, categories.id AS cat_id, categories.name AS cat_name, categories.path FROM products, product_category, categories WHERE products.id = product_category.pro_id AND product_category.cat_id=categories.id ORDER BY priority DESC, created_time DESC");
		
		notify_url=http%3A%2F%2F210.176.126.120%3A81%2Fzh%2Fcheckout%2Fpaypal_ipn&
					ipn_type=4&cmd=_send_ipn-session&
					payment_type=1&
					payment_date=01%3A15%3A19+Apr+30%2C+2012+PDT&
					payment_status=2&
					pending_reason=&
					address_status=1&
					payer_status=1&
					first_name=John&
					last_name=Smith&
					payer_email=buyer%40paypalsandbox.com&
					payer_id=TESTBUYERID01&
					address_name=John+Smith&
					address_country=182&
					address_country_code=182&
					address_zip=95131&
					address_state=CA&
					address_city=San+Jose&
					address_street=123%2C+any+street&
					business=&
					receiver_email=seller%40paypalsandbox.com&
					receiver_id=TESTSELLERID1&
					residence_country=182&
					item_name=&
					item_number=&
					item_name1=something&
					item_number1=AK-1234&
					quantity=&
					quantity1=1&
					shipping=&
					tax=2.02&
					mc_currency=15&
					mc_fee=0.44&
					mc_gross=&
					mc_gross_1=9.34&
					mc_handling=2.06&
					mc_handling1=1.67&
					mc_shipping=3.02&
					mc_shipping1=1.02&
					txn_type=cart&
					txn_id+=19430815&
					parent_txn_id+=&
					notify_version+=2.4&
					auction_buyer_id=&
					auction_closing_date=&
					for_auction=&
					reason_code=&
					receipt_ID=&
					custom=xyz123&
					invoice=abc1234


		$paypal_payment_status = array()
		$payment_status = $order['payment_status'];
		$payment_amount = $order['mc_gross'];
		$payment_currency = $order['mc_currency'];
		$txn_id = $order['txn_id'];

		// product info
		$item_name = $order['item_name'];
		$item_number = $order['item_number'];

		// buyer info
		$payer_email = $order['payer_email'];
		$first_name = $order['first_name'];
		$last_name = $order['last_name'];
		$address_city = $order['address_city'];
		$address_state = $order['address_state'];
		$address_country = $order['address_country'];

		// receiver_email, that's our email address
		$receiver_email = $order['receiver_email'];
		
		$result = $this->db->query("insert into order(id, txn_id, price, created_date, modified_date) values(?, ?,?, $ now(), now()");
		$this->db->query($query, array($order['id'], $order['txn_id'], $order['payment_gross']));
		
		foreach($order as $key=>$each_order){
			$item_num = $key+1;
			$result = $this->db->query("insert into order_items(oid, txn_id, price, discount, quantity, color, size, created_date, modified_date) values(?,?,?,?,?,?,now(),now())");
			$this->db->query($query, array($order['id'], $order['txn_id'], $order['price'], $order['discount'], $order['quantity'], $order['color'], $order['size']));
		}
		return $result->result_array();
	}
	
}

?>