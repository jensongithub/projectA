<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Product_care extends CI_Controller {
	var $data;
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
	}

	public function index(){
		$this->data = array('title'=>'Product_care');
		$this->data = array_merge($this->data, $this->session->all_userdata());
		$lang = '_'.$this->lang->lang();
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/product_care'.$lang);
		$this->load->view("templates/footer");
	}

}