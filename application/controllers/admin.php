<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Admin extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->load->model('user_model');		
		$this->require_login(3);
	}

	public function index(){
		// require_login();
		$this->set_page('title','Administration');
		
		$this->load->view('admin/templates/header', $this->data);
		$this->load->view('admin/templates/menu', $this->data);
		$this->load->view('admin/dashboard', $this->data);
		$this->load->view('admin/templates/footer', $this->data);
	}
	
	public function edit_categories(){
		// require_login();
		
		$this->load->model('category_model');
		
		$this->data['page']['title'] = 'Edit categories';
		$this->data['page']['action'] = '';
		
		$this->load->library('form_validation');
		
		if( $this->input->post('action') == 'add' ){
			$this->form_validation->set_rules('catname-a', 'Category name', 'trim|required|is_unique[categories.name]');
			$this->form_validation->set_message('required', '%s cannot be empty');
			$this->form_validation->set_message('is_unique', '%s already exist');
			if( $this->form_validation->run() == TRUE ) {
				$this->category_model->add_category( $this->input->post('catname-a'), $this->input->post('path-a') );
			}
			else{
				$this->data['page']['action'] = 'add';
			}
		}
		else if( $this->input->post('action') == 'edit' ){
			$this->form_validation->set_rules('ori-catname', 'Original category name', 'min_length[1]');
			$this->form_validation->set_rules('catname-e', 'Category name', 'trim|required');
			$this->form_validation->set_rules('path-e', 'Path', 'trim|required');
			$this->form_validation->set_rules('catid', 'Category ID', 'trim|required|integer');
			$this->form_validation->set_message('required', '%s cannot be empty');
			$this->form_validation->set_message('is_unique', '%s already exist');
			if( $this->form_validation->run() == TRUE ) {
				$columns = array( 'name' => $this->input->post('catname-e'), 'path' => $this->input->post('path-e') );
				$this->category_model->edit_category( $this->input->post('catid'), $columns);
			}
			else{
				$this->data['page']['action'] = 'edit';
			}
		}
		
		$this->data['page']['categories'] = $this->category_model->get_categories();
		$i = 1;
		foreach( $this->data['page']['categories'] as $category ){
			$this->data['page']['cat_json']['cat' . $i] = $category;
			$i++;
		}
		$this->data['page']['cat_json'] = json_encode($this->data['page']['cat_json']);
		
		$this->load->view('admin/templates/header', $this->data);
		$this->load->view('admin/templates/menu', $this->data);
		$this->load->view('admin/categories', $this->data);
		$this->load->view('admin/templates/footer', $this->data);
	}
	
	public function edit_menu(){
		// require_login();
		
		$this->load->model('category_model');
		$this->load->model('menu_model');
		
		$this->data['page']['title'] = 'Edit Menu';
		$this->load->library('form_validation');
		$this->load->helper('json');
		
		$this->data['page']['menu'] = $this->menu_model->get_menu();
		$i = 1;
		foreach( $this->data['page']['menu'] as $menu ){
			$this->data['page']['menu_json']['mi' . $i] = $menu;
			$i++;
		}
		$this->data['page']['menu_json'] = json_encode($this->data['page']['menu_json']);
		$this->data['page']['categories'] = $this->category_model->get_categories();
		
		$this->load->view('admin/templates/header', $this->data);
		$this->load->view('admin/templates/menu', $this->data);
		$this->load->view('admin/menu', $this->data);
		$this->load->view('admin/templates/footer', $this->data);
	}
	
	public function products($cat_id = ''){
		$this->load->helper(array('form'));
		$this->load->model( array('product_model', 'category_model') );
		
		$this->data['page']['cid'] = $cat_id;
		if( $this->input->post('upload') == '1' ){
		}
		else if( $this->input->post('move') == '1' ){
			$cid = $this->input->post('cid');
			$pids = $this->input->post('pid');
			$total = count($pids);
			$this->data['page']['success_count'] = 0;
			$this->data['page']['fail_count'] = 0;
			foreach($pids as $pid){
				if( $this->product_model->move_product_to_cat($pid, $cid) === TRUE)
					$this->data['page']['success_count']++;
				else
					$this->data['page']['fail_count']++;
			}
		}
		
		if( $cat_id == '' ){
			$this->data['page']['products'] = $this->product_model->get_products_in_category();
		}
		else{
			$this->data['page']['products'] = $this->product_model->get_products_in_category($cat_id);
			foreach( $this->data['page']['products'] as $key => $product ){
				$colors = $this->product_model->get_products_color($product['id']);
				$this->data['page']['products'][$key]['colors'] = array();
				foreach( $colors as $color ){
					if( $color['color'] == substr( $product['front_img'], 6, 6) ){
						array_unshift( $this->data['page']['products'][$key]['colors'], $color );
					}
					else{
						$this->data['page']['products'][$key]['colors'][] = $color;
					}
				}
			}
		}

		$this->data['page']['categories'] = $this->category_model->get_categories();
		
		$this->data['page']['title'] = 'Edit products';
		
		$this->load->view('admin/templates/header', $this->data);
		$this->load->view('admin/templates/menu', $this->data);
		$this->load->view('admin/upload_products_form', $this->data);
		$this->load->view('admin/products', $this->data);
		$this->load->view('admin/templates/footer', $this->data);
	}
	
	public function upload_products(){
		$this->load->model( array('product_model') );

		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'xls';
		$config['max_size']	= '1024';

		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload()) { // upload failed
			$this->data['page']['error'] = $this->upload->display_errors();
		}
		else {
			$this->load->library('Excel_reader_2_21');
			$result = $this->product_model->handle_products_excel( $this->upload->data() );
			$this->data['page']['success'] = $result['success'];
			$this->data['page']['fail'] = $result['fail'];
			$this->data['page']['fail_log'] = $result['fail_log'];
		}
		
		$this->data['page']['back'] = anchor('admin/products/', ' << Go back ');
		
		$this->load->view('admin/templates/header', $this->data);
		$this->load->view('admin/templates/menu', $this->data);
		$this->load->view('admin/upload_products_result', $this->data);
		$this->load->view('admin/templates/footer', $this->data);
	}
	
	public function edit_products($id = ''){
		$this->load->helper(array('form'));
		$this->load->model( array('product_model', 'category_model') );
		
		if( $this->input->post('action') == 'edit' )
			$this->product_model->edit_product( $this->input->post() );

		$this->data['page']['product'] = $this->product_model->get_product_by_id($id);
		$this->data['page']['color'] = $this->product_model->get_products_color($id);
		$this->data['page']['category'] = $this->product_model->get_product_category($id);
		if( ! $this->data['page']['category'] ){
			unset($this->data['page']['category']);
			$this->data['page']['back'] = anchor('admin/products/', ' << Go back ');
		}
		else{
			$this->data['page']['back'] = anchor('admin/products/' . $this->data['page']['category']['id'], ' << Go back ');
		}

		$this->data['page']['title'] = "$id | Edit products";

		$this->load->view('admin/templates/header', $this->data);
		$this->load->view('admin/templates/menu', $this->data);
		$this->load->view('admin/edit_product', $this->data);
		$this->load->view('admin/templates/footer', $this->data);
	}
	
	public function sql(){
		$lna_pos = $this->load->database('lna_pos');
		$lna_pos->get('tbl_pos_class_hdr');
		$result = $lna_pos->result_array();
		foreach( $result as $key => $value ){
			echo "$key => $value";
		}
	}
		
	public function edit_content($name){
		// about, company, location, sitemap contact can be editor here
		$lang = '_'.$this->lang->lang();
		$this->data['page']['title']=$name;
		$this->data['page']['view_name']=$name;
		$this->data['page']['filename']='application/views/pages/'.$name.$lang.'.php';
		
		$this->load->view('admin/templates/header', $this->data);
		$this->load->view('admin/editor', $this->data);
		$this->load->view('admin/templates/footer', $this->data);
	}
	
	public function submit_content($name){
		$this->load->helper(array('html','form','url'));
		$lang = '_'.$this->lang->lang();
		$this->data['page']['filename']='application/views/pages/'.$name.$lang.'.php';		
		if(file_exists($this->data['page']['filename'])===TRUE){
			file_put_contents($this->data['page']['filename'], $this->input->post('elm1'));
		}
		redirect(site_url().$this->lang->lang().'/admin/edit_content/'.$name);
	}
}