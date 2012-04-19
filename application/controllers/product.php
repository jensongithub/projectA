<?php
class Product extends CI_Controller {
	var $data=array();
	public function __construct()	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('email');
		$this->data = array_merge($this->data, $this->session->all_userdata());
	}

	public function index()	{
		$data['title'] = 'Product Catalog';
		
		$this->load->helper( array('form') );
		//$this->lang->load('register');
		$this->load->library('form_validation', 'session');
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/product', $this->data);
		$this->load->view('templates/footer');
	}
	
	public function checkout(){
		$this->load->library("paypalExCheckout");
		$this->paypalExCheckout->checkout();
	}
	
}