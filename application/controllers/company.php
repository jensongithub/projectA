<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Company extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
	}

	public function index(){
		$this->load->view("pages/company");
	}

	public function location(){
		$this->load->view("pages/company");
	}

	public function howtoorder(){
		$this->load->view("pages/howtoorder");
	}

	public function contact(){
		$this->load->view('pages/contact');
	}
}