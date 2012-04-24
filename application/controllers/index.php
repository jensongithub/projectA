<?php

class Index extends CI_Controller {
	var $data = array();
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->data = array('title'=>'Home');
		$this->data = array_merge($this->data, $this->session->all_userdata());
		$this->data['cart_counter'] = isset($this->data['cart'])? count($this->data['cart']) : 0;
	}

	public function index(){
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/home');
		$this->load->view('templates/footer');
	}
	
	public function logout(){
		$this->common_model->logout();
	}
}