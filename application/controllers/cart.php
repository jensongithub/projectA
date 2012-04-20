<?php
class cart extends CI_Controller {
	var $data;
	public function __construct()	{
		parent::__construct();		
	}
	
	
	public function add(){
		$this->load->helper( array('form') );
		$this->load->library('form_validation');
		
		$item = $this->input->post('item');

		//$_item = json_decode($item);
		$_item = json_decode($item);
		
		$data = $this->session->all_userdata();
		
		if (!isset($data['cart'])){
			$data['cart']=array();
		}
		if (count($data['cart'])<=20){
			array_push($data['cart'], $_item);
		}
		$this->session->set_userdata($data);
		echo $item;
	}
	
	public function del($item){
		
	}
}

?>