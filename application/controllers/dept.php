<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Dept extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
	}

	public function index(){

	}

	public function accessories($cat='crewnecks'){
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

	public function men($cat='cardigans'){
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

	public function women($cat = '1'){
		$this->load->model( array('category_model', 'menu_model') );
		$this->load->helper( array('json', 'directory') );
		
		$data['title'] = 'WOMEN';
		$data['cat'] = $this->category_model->get_categories($cat);
		
		$data['menu'] = $this->menu_model->get_menu();
		$data['products'] = array();
		$products_set = array();
		
		$map = directory_map('images/products/' . $data['cat']['name'], 3);
		if( is_array($map) ) {
			foreach( $map as $key1 => $item ){
				if( is_array($item) ) {
					foreach($item as $key2 => $floor){
						$str = preg_split( '/[\s-]+/', $floor );
						if( ! in_array( $str[0], $products_set ) && strpos( $floor, '-size.jpg' ) === FALSE ){
							$data['products'][] = array( 'name' => $str[0], 'cat' => $key1 );
							$products_set[] = $str[0];
						}
					}
				}else{
					$str = preg_split( '/[\s-]+/', $item );
					if( ! in_array( $str[0], $products_set ) && strpos( $item, '-size.jpg' ) === FALSE ){
						$data['products'][] = array( 'name' => $str[0] );
						$products_set[] = $str[0];
					}
				}
			}
		}
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/women', $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function view($dept = '', $cat = '', $id = '') {
		$this->load->model('category_model');
		$data['category'] = $this->category_model->get_categories($cat);
		$data['title'] = ucfirst($data['category']['name']) . ' | ' . $id;
		$data['dept'] = $dept;
		$data['cat'] = $data['category']['name'];
		$data['id'] = $id;
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/view_product', $data);
		$this->load->view('templates/footer', $data);
	}
}