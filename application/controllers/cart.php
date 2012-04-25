<?php
class cart extends CI_Controller {
	var $data = array();
	public function __construct()	{
		parent::__construct();
		$this->data['cart'] = array();
		$this->data['title'] = "Cart";
		$this->data = array_merge($this->data, $this->session->all_userdata());
		$this->data['cart_counter'] = isset($this->data['cart'])? count($this->data['cart']) : 0;
	}
	
	public function index(){
		$this->load->model("product_model");				
		
		$item_id = array();
		foreach($this->data['cart'] as $each_item){
			$item_id[] = $each_item['id'];
		}
		
		//get unit price by item code		 
		$product_details = $this->product_model->get_product_by_id($item_id);
		 
		foreach($this->data['cart'] as $key=>$each_item){
			foreach ($product_details as $each_product){
				if ($each_product['id'] === $each_item['id']){
					$this->data['cart'][$key]['price'] = $each_product['price'];
					$this->data['cart'][$key]['discount'] = $each_product['discount'];
				}
			}
		}
		
		$this->session->set_userdata($this->data);
	
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/cart', $this->data);
		$this->load->view('templates/footer', $this->data);
	}
	
	public function add(){
		$this->load->helper( array('form') );
		$this->load->library('form_validation');
		
		$is_same = FALSE;
		$ret = FALSE;
		
		$item = $this->input->post('item');
		$_item = json_decode($item, true);
		$this->data = $this->session->all_userdata();
		
		if (!isset($this->data['cart'])){
			$this->data['cart']=array();
		}
		
		$cart_counter = count($this->data["cart"]);
		
		if ($cart_counter<=20){
			// has to check if product id already exists
			// if code, size and color are same, consolidate!
			foreach($this->data['cart'] as $key=>$each_item){
				if ($each_item['id'] === $_item['id'] && $each_item['color'] === $_item['color'] && $each_item['size'] === $_item['size']){
					$this->data['cart'][$key]['quantity'] += $_item['quantity'];
					$is_same = TRUE;
					$ret = TRUE;
					break;
				}
			}
			
			if (!$is_same){
				$len = array_push($this->data['cart'], $_item);
				if ($len >$cart_counter){
					$cart_counter = $len;
					$ret = TRUE;
				}
			}
		}
		
		$this->session->set_userdata($this->data);		
		if ($is_same) $item="";

		echo <<<JSON
{"cart_item":"$item", "cart_counter":$cart_counter, "success":"$ret"}
JSON;
}
	
	public function del(){
		$is_found = FALSE;
		$ret = FALSE;
		
		$this->load->helper( array('form') );
		$this->load->library('form_validation');
		
		$item = $this->input->post('item');
		$item_id = $this->input->post('item_id');
		$_item = json_decode($item, true);
		$this->data = $this->session->all_userdata();
		if ($_item === NULL){
			$is_found = TRUE;
		}else{
			foreach($this->data['cart'] as $key=>$each_item){
				if ($each_item['id'] === $_item['id'] && $each_item['color'] === $_item['color'] && $each_item['size'] === $_item['size']){
					$is_found = TRUE;
					break;
				}
			}
		}
		
		$ret = array_splice($this->data['cart'], $item_id, 1);		
		$cart_counter = count($this->data["cart"]);		
		$this->session->set_userdata($this->data);
		
		echo <<<JSON
{"cart_item":"", "cart_counter":$cart_counter, "success":"$ret"}
JSON;
	}
}