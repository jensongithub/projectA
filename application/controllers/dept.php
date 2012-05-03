<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Dept extends MY_Controller {
	
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

		$this->set_page('title', ucfirst('women'));
		$this->set_page('cat',ucfirst($cat));		

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

		$this->set_page('title', ucfirst('men'));
		$this->set_page('cat',ucfirst($cat));		

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
		
		$this->set_page('title', ucfirst('Ladies'));
		$this->data['page']['cat']=$this->category_model->get_categories($cat);
		$this->data['page']['menu'] = $this->menu_model->get_submenu('1');
		$this->data['page']['products'] = array();
		$products_set = array();
		
		$map = directory_map('images/products/' . $this->data['cat']['name'], 2);
		if( is_array($map) ) {
			foreach( $map as $key1 => $item ){
				if( is_array($item) ) {
					foreach($item as $key2 => $floor){
						$str = preg_split( '/[\s-]+/', $floor );
						if( ! in_array( $str[0], $products_set ) && strpos( $floor, '-size.jpg' ) === FALSE ){
							$this->data['page']['products'][] = array( 'name' => $str[0], 'cat' => $key1 );
							$products_set[] = $str[0];
						}
					}
				}else{
					$str = preg_split( '/[\s-]+/', $item );
					if( ! in_array( $str[0], $products_set ) && strpos( $item, '-size.jpg' ) === FALSE ){
						$this->data['page']['products'][] = array( 'name' => $str[0] );
						$products_set[] = $str[0];
					}
				}
			}
		}
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/women', $this->data);
		$this->load->view('templates/footer', $this->data);
	}
	
	public function browse($dept = 'ladies', $cat = 'sales', $sub = '', $page = 1){
		$this->load->model( array('category_model', 'menu_model', 'product_model') );
		$this->load->helper( 'url' );

		$this->data['page']['lang'] = $this->lang->lang();

		$dept = urldecode($dept);
		$cat = urldecode($cat);
		if( is_numeric($sub) ){
			$page = $sub;
			$sub = '';
		}
		$sub = urldecode($sub);
		$url = preg_replace( '/(\d+)$/', "", current_url());
		$url = preg_replace( '/\/$/', "", $url) . '/';
		$this->data['page']['url'] = $url;
		$offset = 0;
		$count = 16;
		
		$this->data['page']['path'] = $this->category_model->get_category_by_text($dept, $cat, $sub);

		if( isset($this->data['page']['path'][0]) )
			$this->data['page']['menu'] = $this->menu_model->get_submenu($this->data['page']['path'][0]['level']);
		
		if( $this->data['page']['path'] == FALSE ){
			$this->data['page']['error'] = "No such category: $dept/$cat/$sub";
			$this->data['page']['title'] = $this->data['page']['error'];
			$this->data['page']['path'] = array();
		}
		else if( strcasecmp( $cat, 'sales' ) == 0 ){
			// if category is SALES
			$product_count = 0;

			if( $page > 1 ){
				$offset = ($page - 1) * $count;
				$this->data['page']['prev'] = ($page - 1);
			}

			$this->data['page']['products'] = $this->product_model->get_products_for_sales_listing( $this->data['page']['path'][0]['level'], $offset, $count, $product_count );

			if( $offset + $count < $product_count )
				$this->data['page']['next'] = ($page + 1);

			$this->data['page']['title'] = $this->data['page']['path'][0]['text_' . $this->data['page']['lang']] . '/' . $this->data['page']['path'][1]['text_' . $this->data['page']['lang']];
			$this->load->view('templates/header', $this->data);
			$this->load->view('pages/women', $this->data);
			$this->load->view('templates/footer', $this->data);
			return;
		}
		else{
			$product_count = 0;
			$this->data['page']['cat'] = $this->data['page']['path'][count($this->data['page']['path'])-1]['c_path'];
			$this->data['page']['cat_showcase'] = $this->category_model->get_category_showcase($this->data['page']['path'][count($this->data['page']['path'])-1]['path']);
			
			if( $page > 1 ){
				if( $this->data['page']['cat_showcase'] ){
					$offset = 14 + ($page - 2) * $count;
					unset( $this->data['page']['cat_showcase'] );
				}
				else{
					$offset = ($page - 1) * $count;
				}
				$this->data['page']['prev'] = ($page - 1);
			}
			else if( $this->data['page']['cat_showcase'] ){
				$count = 14;
			}

			$this->data['page']['products'] = $this->product_model->get_products_for_listing( $dept, $cat, $sub, $offset, $count, $product_count );

			if( $offset + $count < $product_count )
				$this->data['page']['next'] = ($page + 1);
			
			$this->data['page']['title'] = $this->data['page']['path'][0]['text_' . $this->data['page']['lang']] . '/' . $this->data['page']['path'][1]['text_' . $this->data['page']['lang']];
		}
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/women', $this->data);
		$this->load->view('templates/footer', $this->data);
	}

	public function view($dept = '', $cat = '', $sub = '', $id = '') {
		$this->load->model( array('category_model', 'product_model', 'component_model') );
		$this->load->library('zh2cn');
		$this->data['page']['lang'] = $this->lang->lang();
		$dept = urldecode($dept);
		$cat = urldecode($cat);
		$sub = urldecode($sub);

		$this->data['page']['c_path'] = $this->category_model->get_category_by_text($dept, $cat, $sub);
		//print_r($this->data['c_path']);

		$this->data['page']['id'] = $id;
		
		$this->data['page']['product'] = $this->product_model->get_product_by_id($id, FALSE);
		if( ! $this->data['page']['product'] ){
			$this->data['page']['title'] = _('No such product') . ": $id";
			$this->load->view('templates/header', $this->data);
			$this->load->view('pages/no_product', $this->data);
			$this->load->view('templates/footer', $this->data);
			return;
		}
		
		$this->data['page']['category'] = $this->data['page']['c_path'][count($this->data['page']['c_path'])-1];
		$this->data['page']['path'] = base_url() . 'images/products/' . $this->data['page']['category']['path'];
		$this->data['page']['title'] = $id . ' | ' . ucfirst($this->data['page']['category']['text_en']);
		$this->data['page']['dept'] = $dept;
		$this->data['page']['i_path'] = $this->data['page']['category']['path'];

		$colors = $this->product_model->get_products_color($id);
		$this->load->helper('json');
		$this->data['page']['colors'] = array();
		foreach( $colors as $key => $color ){
			if( $color['color'] == substr( $this->data['page']['product']['front_img'], 6, 6) ){
				array_unshift( $this->data['page']['colors'], $color );
			}
			else{
				$this->data['page']['colors'][] = $color;
			}
		}
		foreach( $this->data['page']['colors'] as $key => $color ){
			$this->data['page']['colors_json']["c$key"] = $color;
		}
		$this->data['page']['colors_json'] = json_encode($this->data['page']['colors_json']);
		
		$this->data['page']['product']['comp_list'] = $this->component_model->get_components_from_json( json_decode($this->data['page']['product']['components']) );

		if( $this->data['page']['lang'] == 'cn' ){
			$this->data['page']['product']['description_cn'] = $this->zh2cn->convert( $this->data['page']['product']['description_zh'] );
			foreach( $this->data['page']['product']['comp_list'] as $key => $val ){
				$this->data['page']['product']['comp_list'][$key]['name_cn'] = $this->zh2cn->convert( $val['name_zh'] );
			}
		}

		// get similar products
		$this->data['page']['sim_pro'] = $this->product_model->get_similar_products($this->data['page']['id'], $this->data['page']['category']['id'], 4);
		//$sims = $this->product_model->get_products_in_category($this->data['page']['category']['id']);
		
		$this->data['page']['add_cart_url'] = site_url().$this->lang->lang()."/cart/add/";
		$this->data['page']['del_cart_url'] = site_url().$this->lang->lang()."/cart/del/";
		$this->data['page']['payment_url'] = site_url().$this->lang->lang()."/checkout/payment";
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/view_product', $this->data);
		$this->load->view('templates/footer', $this->data);
	}
}