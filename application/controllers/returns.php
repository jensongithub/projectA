<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Returns extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->set_page('title','Goods Return');
	}

	public function index(){
		
		$lang = '_'.$this->lang->lang();
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/returns'.$lang);
		$this->load->view('templates/footer');
	}
}
