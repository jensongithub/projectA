<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Company extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');	
	}

	public function index(){
		$this->set_page('title','Company');
		$lang = '_'.$this->lang->lang();		
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/company'.$lang);
		$this->load->view('templates/footer');
	}
}
