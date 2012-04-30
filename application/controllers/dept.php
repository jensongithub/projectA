<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Dept extends CI_Controller {
	var $data;
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->data=array();
		$this->data = array_merge($this->data, $this->session->all_userdata());
		$this->data['cart_counter'] = isset($this->data['cart'])? count($this->data['cart']) : 0;
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
	
	public function browse($dept = 'women', $cat = 'sales', $sub = '', $page = 1){
		$this->load->model( array('category_model', 'menu_model', 'product_model') );
		$this->load->helper( 'url' );

		$dept = urldecode($dept);
		$cat = urldecode($cat);
		if( is_numeric($sub) ){
			$page = $sub;
			$sub = '';
		}
		$sub = urldecode($sub);
		$url = preg_replace( '/(\d+)$/', "", current_url());
		$url = preg_replace( '/\/$/', "", $url) . '/';
		$this->data['url'] = $url;
		$offset = 0;
		$count = 16;
		$this->data['path'] = $this->category_model->get_category_by_text($dept, $cat, $sub);
		if( $this->data['path'] == FALSE ){
			$this->data['error'] = "No such category: $dept/$cat/$sub";
			$this->data['title'] = $this->data['error'];
			$this->data['path'] = array();
		}
		else{
			for( $i = 0; isset($this->data['path'][$i]); $i++);
			$this->data['cat'] = $this->data['path'][$i-1]['c_path'];
			$this->data['cat_showcase'] = $this->category_model->get_category_showcase($this->data['path'][$i-1]['path']);
			//echo "thumbnail: " . (isset($this->data['cat_showcase'])?'Y':'N');
			
			if( $page > 1 ){
				if( $this->data['cat_showcase'] ){
					$offset = 14 + ($page - 2) * $count;
					unset( $this->data['cat_showcase'] );
				}
				else{
					$offset = ($page - 1) * $count;
				}
				$this->data['prev'] = ($page - 1);
			}
			else if( $this->data['cat_showcase'] ){
				$count = 14;
			}
			
			if( $offset + $count < $this->category_model->get_number_of_products($this->data['path'][$i-1]['id']) )
				$this->data['next'] = ($page + 1);
			
			$this->data['title'] = ucfirst($this->data['cat']);
		}
		$this->data['menu'] = $this->menu_model->get_submenu('1');

		//echo "<br/>page: $page, offset: $offset, count: $count";
		$this->data['products'] = $this->product_model->get_products_for_listing( $dept, $cat, $sub, $offset, $count );
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/women', $this->data);
		$this->load->view('templates/footer', $this->data);
	}

	public function view($dept = '', $cat = '', $sub = '', $id = '') {
		$this->load->model( array('category_model', 'product_model', 'component_model') );
		$dept = urldecode($dept);
		$cat = urldecode($cat);
		$sub = urldecode($sub);

		$this->data['c_path'] = $this->category_model->get_category_by_text($dept, $cat, $sub);
		//print_r($this->data['c_path']);
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
		
		$this->data['product']['comp_list'] = $this->component_model->get_components_from_json( json_decode($this->data['product']['components']) );

		// get similar products
		$this->data['sim_pro'] = $this->product_model->get_similar_products($this->data['id'], $this->data['category']['id'], 4);
		//$sims = $this->product_model->get_products_in_category($this->data['category']['id']);
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/view_product', $this->data);
		$this->load->view('templates/footer', $this->data);
	}
}