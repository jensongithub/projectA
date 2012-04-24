<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Returns extends CI_Controller {
	var $data =array();
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->data = array('title'=>'Goods Return');
		$this->data = array_merge($this->data, $this->session->all_userdata());
		$this->data['cart_counter'] = isset($this->data['cart'])? count($this->data['cart']) : 0;
	}

	public function index(){
		
		$lang = '_'.$this->lang->lang();
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/returns'.$lang);
		$this->load->view('templates/footer');
	}
}
