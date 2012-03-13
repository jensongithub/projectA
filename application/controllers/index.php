<?php

class Index extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
	}

	public function index(){
		$data = array('title'=>'Home');
		$data = array_merge($data, $this->session->all_userdata());
		$this->load->view('templates/header', $data);
		$this->load->view('pages/home');
		$this->load->view('templates/footer' );
	}
	
	public function logout(){
		$this->common_model->logout();
	}
}