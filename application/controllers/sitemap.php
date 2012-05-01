<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Sitemap extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
	}

	public function index(){
		$this->set_page('title'],'Sitemap');
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/sitemap');
		$this->load->view('templates/footer');
	}
}