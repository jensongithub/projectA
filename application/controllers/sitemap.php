<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Sitemap extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
	}

	public function index(){
		$data['title'] = 'Sitemap';
		$this->load->view('templates/header', $data);
		$this->load->view('pages/sitemap');
		$this->load->view('templates/footer');
	}
}