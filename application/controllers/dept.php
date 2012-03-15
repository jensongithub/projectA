<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Dept extends CI_Controller {
	var $data;
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->data=array();
		$this->data = array_merge($this->data, $this->session->all_userdata());
	}

	public function index(){
		
	}

	public function accessories($cat='crewnecks'){
		// load language file
		// $this->lang->load('women');
		//$this->lang->lang();

		$this->data['title'] = ucfirst('women');
		$this->data['cat'] = ucfirst($cat);

		switch($cat){
			case 'cardigans':
				$this->data['products'][] = 'DSL420-2a.jpg';
				$this->data['products'][] = 'IMG_2511a.jpg';
				$this->data['products'][] = 'IMG_2525a.jpg';
				$this->data['products'][] = 'IMG_2556a.jpg';
				$this->data['products'][] = 'IMG_2559a.jpg';
				break;
			case 'crewnecks':
				$this->data['products'][] = 'DSL272-5a.jpg';
				$this->data['products'][] = 'DSL421-5a.jpg';
				$this->data['products'][] = 'DSL424-1a.jpg';
				$this->data['products'][] = 'DSL424-3a.jpg';
				$this->data['products'][] = 'DSL433-1a.jpg';
				$this->data['products'][] = 'DSL499-4a.jpg';
				$this->data['products'][] = 'IMG_2500a.jpg';
				$this->data['products'][] = 'IMG_2533a.jpg';
				$this->data['products'][] = 'IMG_2543a.jpg';
				break;
			case 'sweaters':
				$this->data['products'][] = 'DSL420-2a.jpg';
				$this->data['products'][] = 'IMG_2525a.jpg';
				$this->data['products'][] = 'IMG_2559a.jpg';
				$this->data['products'][] = 'DSL272-5a.jpg';
				$this->data['products'][] = 'IMG_2511a.jpg';
				$this->data['products'][] = 'DSL421-5a.jpg';
				$this->data['products'][] = 'DSL424-1a.jpg';
				$this->data['products'][] = 'DSL424-3a.jpg';
				$this->data['products'][] = 'DSL433-1a.jpg';
				$this->data['products'][] = 'DSL499-4a.jpg';
				$this->data['products'][] = 'IMG_2500a.jpg';
				$this->data['products'][] = 'IMG_2556a.jpg';
				$this->data['products'][] = 'IMG_2533a.jpg';
				$this->data['products'][] = 'IMG_2543a.jpg';
				break;
		}
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/women', $this->data);
		$this->load->view('templates/footer', $this->data);
	}

	public function men($cat='cardigans'){
	// load language file
		// $this->lang->load('women');
		//$this->lang->lang();

		$this->data['title'] = ucfirst('women');
		$this->data['cat'] = ucfirst($cat);

		switch($cat){
			case 'cardigans':
				$this->data['products'][] = 'DSL420-2a.jpg';
				$this->data['products'][] = 'IMG_2511a.jpg';
				$this->data['products'][] = 'IMG_2525a.jpg';
				$this->data['products'][] = 'IMG_2556a.jpg';
				$this->data['products'][] = 'IMG_2559a.jpg';
				break;
			case 'crewnecks':
				$this->data['products'][] = 'DSL272-5a.jpg';
				$this->data['products'][] = 'DSL421-5a.jpg';
				$this->data['products'][] = 'DSL424-1a.jpg';
				$this->data['products'][] = 'DSL424-3a.jpg';
				$this->data['products'][] = 'DSL433-1a.jpg';
				$this->data['products'][] = 'DSL499-4a.jpg';
				$this->data['products'][] = 'IMG_2500a.jpg';
				$this->data['products'][] = 'IMG_2533a.jpg';
				$this->data['products'][] = 'IMG_2543a.jpg';
				break;
			case 'sweaters':
				$this->data['products'][] = 'DSL420-2a.jpg';
				$this->data['products'][] = 'IMG_2525a.jpg';
				$this->data['products'][] = 'IMG_2559a.jpg';
				$this->data['products'][] = 'DSL272-5a.jpg';
				$this->data['products'][] = 'IMG_2511a.jpg';
				$this->data['products'][] = 'DSL421-5a.jpg';
				$this->data['products'][] = 'DSL424-1a.jpg';
				$this->data['products'][] = 'DSL424-3a.jpg';
				$this->data['products'][] = 'DSL433-1a.jpg';
				$this->data['products'][] = 'DSL499-4a.jpg';
				$this->data['products'][] = 'IMG_2500a.jpg';
				$this->data['products'][] = 'IMG_2556a.jpg';
				$this->data['products'][] = 'IMG_2533a.jpg';
				$this->data['products'][] = 'IMG_2543a.jpg';
				break;
		}
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/women', $this->data);
		$this->load->view('templates/footer', $this->data);
	}

	public function women($cat='sweaters'){
		$this->data['title'] = ucfirst('women');
		$this->data['cat'] = $cat;

		switch($cat){
			case 'cardigans':
				$this->data['products'][] = 'DSL420-2a.jpg';
				$this->data['products'][] = 'IMG_2511a.jpg';
				$this->data['products'][] = 'IMG_2525a.jpg';
				$this->data['products'][] = 'IMG_2556a.jpg';
				$this->data['products'][] = 'IMG_2559a.jpg';
				break;
			case 'crewnecks':
				$this->data['products'][] = 'DSL272-5a.jpg';
				$this->data['products'][] = 'DSL421-5a.jpg';
				$this->data['products'][] = 'DSL424-1a.jpg';
				$this->data['products'][] = 'DSL424-3a.jpg';
				$this->data['products'][] = 'DSL433-1a.jpg';
				$this->data['products'][] = 'DSL499-4a.jpg';
				$this->data['products'][] = 'IMG_2500a.jpg';
				$this->data['products'][] = 'IMG_2533a.jpg';
				$this->data['products'][] = 'IMG_2543a.jpg';
				break;
			case 'sweaters':
				$this->data['products'][] = 'DSL420-2a.jpg';
				$this->data['products'][] = 'IMG_2525a.jpg';
				$this->data['products'][] = 'IMG_2559a.jpg';
				$this->data['products'][] = 'DSL272-5a.jpg';
				$this->data['products'][] = 'IMG_2511a.jpg';
				$this->data['products'][] = 'DSL421-5a.jpg';
				$this->data['products'][] = 'DSL424-1a.jpg';
				$this->data['products'][] = 'DSL424-3a.jpg';
				$this->data['products'][] = 'DSL433-1a.jpg';
				$this->data['products'][] = 'DSL499-4a.jpg';
				$this->data['products'][] = 'IMG_2500a.jpg';
				$this->data['products'][] = 'IMG_2556a.jpg';
				$this->data['products'][] = 'IMG_2533a.jpg';
				$this->data['products'][] = 'IMG_2543a.jpg';
				break;
		}
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/women', $this->data);
		$this->load->view('templates/footer', $this->data);
	}
	
	public function view($dept = '', $cat = '', $id = '') {
		$this->data['title'] = ucfirst($dept) . ' | ' . ucfirst($cat) . ' | ' . $id;
		$this->data['dept'] = $dept;
		$this->data['cat'] = $cat;
		$this->data['id'] = $id;
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/view_product', $this->data);
		$this->load->view('templates/footer', $this->data);
	}
}