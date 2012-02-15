<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Company extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
	}

	public function index(){
		$data = array('title'=>'Company');
		$this->load->view('templates/header', $data);
		$this->load->view("pages/company");
		$this->load->view("templates/footer");
	}

}