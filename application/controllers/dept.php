<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Dept extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
	}

	public function index(){

	}

	public function accessories($cat=''){
		// load language file
		// $this->lang->load('women');
		//$this->lang->lang();

		$data['title'] = ucfirst('women');
		$data['cat'] = ucfirst($cat);

		switch($cat){
			case 'cardigans':
				$data['products'][] = 'DSL420-2a.jpg';
				$data['products'][] = 'IMG_2511a.jpg';
				$data['products'][] = 'IMG_2525a.jpg';
				$data['products'][] = 'IMG_2556a.jpg';
				$data['products'][] = 'IMG_2559a.jpg';
				break;
			case 'crewnecks':
				$data['products'][] = 'DSL272-5a.jpg';
				$data['products'][] = 'DSL421-5a.jpg';
				$data['products'][] = 'DSL424-1a.jpg';
				$data['products'][] = 'DSL424-3a.jpg';
				$data['products'][] = 'DSL433-1a.jpg';
				$data['products'][] = 'DSL499-4a.jpg';
				$data['products'][] = 'IMG_2500a.jpg';
				$data['products'][] = 'IMG_2533a.jpg';
				$data['products'][] = 'IMG_2543a.jpg';
				break;
			case 'sweaters':
				$data['products'][] = 'DSL420-2a.jpg';
				$data['products'][] = 'IMG_2525a.jpg';
				$data['products'][] = 'IMG_2559a.jpg';
				$data['products'][] = 'DSL272-5a.jpg';
				$data['products'][] = 'IMG_2511a.jpg';
				$data['products'][] = 'DSL421-5a.jpg';
				$data['products'][] = 'DSL424-1a.jpg';
				$data['products'][] = 'DSL424-3a.jpg';
				$data['products'][] = 'DSL433-1a.jpg';
				$data['products'][] = 'DSL499-4a.jpg';
				$data['products'][] = 'IMG_2500a.jpg';
				$data['products'][] = 'IMG_2556a.jpg';
				$data['products'][] = 'IMG_2533a.jpg';
				$data['products'][] = 'IMG_2543a.jpg';
				break;
		}
		$this->load->view('templates/header', $data);
		$this->load->view('pages/women', $data);
		$this->load->view('templates/footer', $data);
	}

	public function men($cat=''){
	// load language file
		// $this->lang->load('women');
		//$this->lang->lang();

		$data['title'] = ucfirst('women');
		$data['cat'] = ucfirst($cat);

		switch($cat){
			case 'cardigans':
				$data['products'][] = 'DSL420-2a.jpg';
				$data['products'][] = 'IMG_2511a.jpg';
				$data['products'][] = 'IMG_2525a.jpg';
				$data['products'][] = 'IMG_2556a.jpg';
				$data['products'][] = 'IMG_2559a.jpg';
				break;
			case 'crewnecks':
				$data['products'][] = 'DSL272-5a.jpg';
				$data['products'][] = 'DSL421-5a.jpg';
				$data['products'][] = 'DSL424-1a.jpg';
				$data['products'][] = 'DSL424-3a.jpg';
				$data['products'][] = 'DSL433-1a.jpg';
				$data['products'][] = 'DSL499-4a.jpg';
				$data['products'][] = 'IMG_2500a.jpg';
				$data['products'][] = 'IMG_2533a.jpg';
				$data['products'][] = 'IMG_2543a.jpg';
				break;
			case 'sweaters':
				$data['products'][] = 'DSL420-2a.jpg';
				$data['products'][] = 'IMG_2525a.jpg';
				$data['products'][] = 'IMG_2559a.jpg';
				$data['products'][] = 'DSL272-5a.jpg';
				$data['products'][] = 'IMG_2511a.jpg';
				$data['products'][] = 'DSL421-5a.jpg';
				$data['products'][] = 'DSL424-1a.jpg';
				$data['products'][] = 'DSL424-3a.jpg';
				$data['products'][] = 'DSL433-1a.jpg';
				$data['products'][] = 'DSL499-4a.jpg';
				$data['products'][] = 'IMG_2500a.jpg';
				$data['products'][] = 'IMG_2556a.jpg';
				$data['products'][] = 'IMG_2533a.jpg';
				$data['products'][] = 'IMG_2543a.jpg';
				break;
		}
		$this->load->view('templates/header', $data);
		$this->load->view('pages/women', $data);
		$this->load->view('templates/footer', $data);
	}

	public function women($cat='sweaters'){
		$data['title'] = ucfirst('women');
		$data['cat'] = $cat;

		switch($cat){
			case 'cardigans':
				$data['products'][] = 'DSL420-2a.jpg';
				$data['products'][] = 'IMG_2511a.jpg';
				$data['products'][] = 'IMG_2525a.jpg';
				$data['products'][] = 'IMG_2556a.jpg';
				$data['products'][] = 'IMG_2559a.jpg';
				break;
			case 'crewnecks':
				$data['products'][] = 'DSL272-5a.jpg';
				$data['products'][] = 'DSL421-5a.jpg';
				$data['products'][] = 'DSL424-1a.jpg';
				$data['products'][] = 'DSL424-3a.jpg';
				$data['products'][] = 'DSL433-1a.jpg';
				$data['products'][] = 'DSL499-4a.jpg';
				$data['products'][] = 'IMG_2500a.jpg';
				$data['products'][] = 'IMG_2533a.jpg';
				$data['products'][] = 'IMG_2543a.jpg';
				break;
			case 'sweaters':
				$data['products'][] = 'DSL420-2a.jpg';
				$data['products'][] = 'IMG_2525a.jpg';
				$data['products'][] = 'IMG_2559a.jpg';
				$data['products'][] = 'DSL272-5a.jpg';
				$data['products'][] = 'IMG_2511a.jpg';
				$data['products'][] = 'DSL421-5a.jpg';
				$data['products'][] = 'DSL424-1a.jpg';
				$data['products'][] = 'DSL424-3a.jpg';
				$data['products'][] = 'DSL433-1a.jpg';
				$data['products'][] = 'DSL499-4a.jpg';
				$data['products'][] = 'IMG_2500a.jpg';
				$data['products'][] = 'IMG_2556a.jpg';
				$data['products'][] = 'IMG_2533a.jpg';
				$data['products'][] = 'IMG_2543a.jpg';
				break;
		}
		$this->load->view('templates/header', $data);
		$this->load->view('pages/women', $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function view($dept = '', $cat = '', $id = '') {
		$data['title'] = ucfirst($dept) . ' | ' . ucfirst($cat) . ' | ' . $id;
		$data['dept'] = $dept;
		$data['cat'] = $cat;
		$data['id'] = $id;
		$this->load->view('templates/header', $data);
		$this->load->view('pages/view_product', $data);
		$this->load->view('templates/footer', $data);
	}
}