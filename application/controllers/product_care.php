<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Product_care extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->set_page('title','Product Care');
	}

	public function index(){
		$lang = $this->lang->lang();
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/product_care_'.$lang);
		$this->load->view("templates/footer");
	}

}