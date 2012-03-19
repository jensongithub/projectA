<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Delivery extends CI_Controller {
	var $data;
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
	}

	public function index(){
		$this->data = array('title'=>'Delivery');
		$this->data = array_merge($this->data, $this->session->all_userdata());
		$lang = '_'.$this->lang->lang();
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/delivery'.$lang);
		$this->load->view('templates/footer');
	}
}
