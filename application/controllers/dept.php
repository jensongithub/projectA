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

	public function women($cat = '1'){
		$this->load->model( array('category_model', 'menu_model') );
		$this->load->helper( array('json', 'directory') );
		
		$this->data['title'] = 'WOMEN';
		$this->data['cat'] = $this->category_model->get_categories($cat);
		
		$this->data['menu'] = $this->menu_model->get_submenu('1');
		$this->data['products'] = array();
		$products_set = array();
		
		$map = directory_map('images/products/' . $this->data['cat']['name'], 2);
		if( is_array($map) ) {
			foreach( $map as $key1 => $item ){
				if( is_array($item) ) {
					foreach($item as $key2 => $floor){
						$str = preg_split( '/[\s-]+/', $floor );
						if( ! in_array( $str[0], $products_set ) && strpos( $floor, '-size.jpg' ) === FALSE ){
							$this->data['products'][] = array( 'name' => $str[0], 'cat' => $key1 );
							$products_set[] = $str[0];
						}
					}
				}else{
					$str = preg_split( '/[\s-]+/', $item );
					if( ! in_array( $str[0], $products_set ) && strpos( $item, '-size.jpg' ) === FALSE ){
						$this->data['products'][] = array( 'name' => $str[0] );
						$products_set[] = $str[0];
					}
				}
			}
		}
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/women', $this->data);
		$this->load->view('templates/footer', $this->data);
	}
	
	public function browse($dept = 'women', $cat = 'sales', $sub = ''){
		$this->load->model( array('category_model', 'menu_model', 'product_model') );
		$dept = urldecode($dept);
		$cat = urldecode($cat);
		$sub = urldecode($sub);
		
		$this->data['path'] = $this->category_model->get_category_by_text($dept, $cat, $sub);
		if( $this->data['path'] == FALSE ){
			$this->data['error'] = "No such category: $dept/$cat/$sub";
			$this->data['title'] = $this->data['error'];
			$this->data['path'] = array();
		}
		else{
			for( $i = 0; isset($this->data['path'][$i]); $i++);
			$this->data['cat'] = $this->data['path'][$i-1]['c_path'];
			$this->data['title'] = ucfirst($this->data['cat']);
		}

		$this->data['menu'] = $this->menu_model->get_submenu('1');
		$this->data['products'] = $this->product_model->get_products_for_listing( $dept, $cat, $sub );
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/women', $this->data);
		$this->load->view('templates/footer', $this->data);
	}

	public function view($dept = '', $cat = '', $sub = '', $id = '') {
		$this->load->model( array('category_model', 'product_model') );
		$dept = urldecode($dept);
		$cat = urldecode($cat);
		$sub = urldecode($sub);

		$this->data['c_path'] = $this->category_model->get_category_by_text($dept, $cat, $sub);
		print_r($this->data['c_path']);
		$this->data['category'] = $this->data['c_path'][count($this->data['c_path'])-1];
		$this->data['path'] = base_url() . 'images/products/' . $this->data['category']['path'];
		$this->data['title'] = $id . ' | ' . ucfirst($this->data['category']['name']);
		$this->data['dept'] = $dept;
		$this->data['cat'] = $this->data['category']['name'];
		$this->data['id'] = $id;
		$this->data['product'] = $this->product_model->get_product_by_id($id);
		
		$this->data['colors'] = $this->product_model->get_products_color($id);
		$this->load->helper('json');
		foreach( $this->data['colors'] as $key => $color ){
			$this->data['colors_json']["c$key"] = $color;
		}
		$this->data['colors_json'] = json_encode($this->data['colors_json']);
		
		$sims = $this->product_model->get_products_in_category($this->data['category']['id']);
		$i = 0;
		$this->data['sim_pro'] = array();
		foreach( $sims as $sim ){
			if( $i < 4 && $sim['id'] != $id ){
				$colors = $this->product_model->get_products_color($sim['id']);
				foreach( $colors as $color ){
					$file = 'images/products/' . $this->data['category']['path'] . '/' . $sim['id'] . $color['color'];
					if( file_exists($file . '-F_s.jpg') || file_exists($file . '-F.jpg') ){
						$this->data['sim_pro'][$i] = $sim;
						$this->data['sim_pro'][$i]['color'] = $color['color'];
						$i++;
						break;
					}
				}
			}
		}
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/view_product', $this->data);
		$this->load->view('templates/footer', $this->data);
	}
}