<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Info extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->set_page('title','Info');
	
	}

	public function index(){		
		$lang = '_'.$this->lang->lang();
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/info'.$lang);
		$this->load->view("templates/footer");
	}

}