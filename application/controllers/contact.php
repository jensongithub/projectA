<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Contact extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
	}

	public function index(){
		$data = array('title'=>'Contact');
		$this->load->view('templates/header', $data);
		$this->load->view("pages/contact");
		$this->load->view("templates/footer");
	}

}