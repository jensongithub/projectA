<?php

class Index extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		/*
		$this->lang->load('header');
		$this->lang->load('footer');
		$this->lang->load('home');
		*/
	}

	public function index(){
		$data = array('title'=>'Home');
		$this->load->view('templates/header', $data);
		$this->load->view('pages/home');
		$this->load->view('templates/footer' );
	}
}