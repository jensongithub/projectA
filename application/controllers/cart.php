<?php
class cart extends MY_Controller {
	
	public function __construct()	{
		parent::__construct();
		$this->data['page']['title']='Cart';
		$this->data['page']['lang'] = $this->lang->lang();
	}
	
	public function index(){
		$this->load->model("product_model");				
		
		$this->data['page']['add_cart_url'] = site_url().$this->lang->lang()."/cart/add/";
		$this->data['page']['del_cart_url'] = site_url().$this->lang->lang()."/cart/del/";
		$this->data['page']['payment_url'] = site_url().$this->lang->lang()."/checkout/payment";
		
		$product_details = $this->product_model->get_cart_item_price($this->data['cart']);
		foreach($this->data['cart'] as $key=>$each_item){
			foreach ($product_details as $each_product){
				if ($each_product['id'] === $each_item['id']){
					$this->data['cart'][$key]['price'] = $each_product['price'];
					$this->data['cart'][$key]['discount'] = $each_product['discount'];
				}
			}
			$color_from_pos = FALSE;
			//$color_from_pos = $this->common_model->get_color_by_id($each_item['color']);
			
			if( $color_from_pos ){
				$this->data['cart'][$key]['color_name'] = array();
				foreach( $color_from_pos[$this->data['cart'][$key]['color']] as $lang => $val ){
					$this->data['cart'][$key]['color_name'][$lang] = $val;
				}
				
				if( $color_from_pos && $this->data['page']['lang'] == 'cn' ){
					$this->load->library('zh2cn');
					$this->data['cart'][$key]['color_name']['name_cn'] = $this->zh2cn->convert( $this->data['cart'][$key]['color_name']['name_zh'] );
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
		if ($is_same) $item='""';

		echo <<<JSON
{"cart_item":$item, "item_count":"$cart_counter", "success":"$ret"}
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
{"cart_item":"", "item_count":"$cart_counter", "success":"$ret"}
JSON;
	}
}