<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Sitemap extends CI_Controller {
	var $data;
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->data = array();
		$this->data = array_merge($this->data, $this->session->all_userdata());
	}

	public function index(){
		$this->data['title'] = 'Sitemap';
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/sitemap');
		$this->load->view('templates/footer');
	}
}