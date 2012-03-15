<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Contact extends CI_Controller {
	var $data;
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
	}

	public function index(){
		$this->data = array('title'=>'Contact');
		$this->data = array_merge($this->data, $this->session->all_userdata());
		$this->load->view('templates/header', $this->data);
		$this->load->view("pages/contact");
		$this->load->view("templates/footer");
	}

}