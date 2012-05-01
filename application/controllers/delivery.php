<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Delivery extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->set_page('title', 'Delivery');
	}

	public function index(){		
		$lang = '_'.$this->lang->lang();
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/delivery'.$lang);
		$this->load->view('templates/footer');
	}
}
