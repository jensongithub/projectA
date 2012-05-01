<?php

class Index extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->set_page('title',"home");
	}

	public function index(){
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/home');
		$this->load->view('templates/footer');
	}
}