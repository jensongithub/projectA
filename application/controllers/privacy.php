<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Privacy extends CI_Controller {
	var $data;
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
	}

	public function index(){
		$this->data = array('title'=>'Privacy');
		$this->data = array_merge($this->data, $this->session->all_userdata());
		$lang = '_'.$this->lang->lang();
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/privacy'.$lang);
		$this->load->view('templates/footer');
	}
}
