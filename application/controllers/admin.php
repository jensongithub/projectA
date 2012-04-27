<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Admin extends CI_Controller {
	var $data;
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->load->model('user_model');
		$this->data = array();
		$this->data = array_merge($this->data, $this->session->all_userdata());
		$this->data['cart_counter'] = isset($this->data['cart'])? count($this->data['cart']) : 0;
		
		$this->user_model->require_login(1);
	}

	public function index(){
		// require_login();
		$this->data['title'] = 'Administration';
		
		$this->load->view('admin/templates/header', $this->data);
		$this->load->view('admin/templates/menu', $this->data);
		$this->load->view('admin/dashboard', $this->data);
		$this->load->view('admin/templates/footer', $this->data);
	}
	
	public function edit_categories(){
		// require_login();
		
		$this->load->model('category_model');
		
		$this->data['title'] = 'Edit categories';
		$this->data['action'] = '';
		
		$this->load->library('form_validation');
		
		if( $this->input->post('action') == 'add' ){
			$this->form_validation->set_rules('catname-a', 'Category name', 'trim|required|is_unique[categories.name]');
			$this->form_validation->set_message('required', '%s cannot be empty');
			$this->form_validation->set_message('is_unique', '%s already exist');
			if( $this->form_validation->run() == TRUE ) {
				$this->category_model->add_category( $this->input->post('catname-a'), $this->input->post('path-a') );
			}
			else{
				$this->data['action'] = 'add';
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
				$this->data['action'] = 'edit';
			}
		}
		
		$this->data['categories'] = $this->category_model->get_categories();
		$i = 1;
		foreach( $this->data['categories'] as $category ){
			$this->data['cat_json']['cat' . $i] = $category;
			$i++;
		}
		$this->data['cat_json'] = json_encode($this->data['cat_json']);
		
		$this->load->view('admin/templates/header', $this->data);
		$this->load->view('admin/templates/menu', $this->data);
		$this->load->view('admin/categories', $this->data);
		$this->load->view('admin/templates/footer', $this->data);
	}
	
	public function edit_menu(){
		// require_login();
		
		$this->load->model('category_model');
		$this->load->model('menu_model');
		
		$this->data['title'] = 'Edit Menu';
		$this->load->library('form_validation');
		$this->load->helper('json');
		
		$this->data['menu'] = $this->menu_model->get_menu();
		$i = 1;
		foreach( $this->data['menu'] as $menu ){
			$this->data['menu_json']['mi' . $i] = $menu;
			$i++;
		}
		$this->data['menu_json'] = json_encode($this->data['menu_json']);
		$this->data['categories'] = $this->category_model->get_categories();
		
		$this->load->view('admin/templates/header', $this->data);
		$this->load->view('admin/templates/menu', $this->data);
		$this->load->view('admin/menu', $this->data);
		$this->load->view('admin/templates/footer', $this->data);
	}
	
	public function products(){
		// require_login();
		
		$this->load->helper(array('form'));
		$this->load->model( array('product_model', 'category_model') );
		
		$this->load->library('zh2cn');
		echo $this->zh2cn->convert('繁體中文 - 萬國碼<br/>');
		
		if( $this->input->post('upload') == '1' ){
		}
		else if( $this->input->post('move') == '1' ){
			$cid = $this->input->post('cid');
			$pids = $this->input->post('pid');
			$total = count($pids);
			$this->data['success_count'] = 0;
			$this->data['fail_count'] = 0;
			foreach($pids as $pid){
				if( $this->product_model->move_product_to_cat($pid, $cid) === TRUE)
					$this->data['success_count']++;
				else
					$this->data['fail_count']++;
			}
		}
		
		$this->data['products'] = $this->product_model->get_products();
		$this->data['categories'] = $this->category_model->get_categories();
		
		$this->data['title'] = 'Edit products';
		
		$this->load->view('admin/templates/header', $this->data);
		$this->load->view('admin/templates/menu', $this->data);
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
			$this->data['error'] = $this->upload->display_errors();
		}
		else {
			$this->load->library('Excel_reader_2_21');
			$result = $this->product_model->handle_products_excel( $this->upload->data() );
			print_r($result);
		}
	}
	
	public function edit_products($id = ''){
		$this->load->helper(array('form'));
		$this->load->model( array('product_model', 'category_model') );
		
		if( $this->input->post('action') == 'edit' )
			$this->product_model->edit_product( $this->input->post() );

		$this->data['product'] = $this->product_model->get_product_by_id($id);
		$this->data['title'] = "$id | Edit products";

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
		$this->data['title']=$name;
		$this->data['view_name']=$name;
		$this->data['filename']='application/views/pages/'.$name.$lang.'.php';
		
		$this->load->view('admin/templates/header', $this->data);
		$this->load->view('admin/editor', $this->data);
		$this->load->view('admin/templates/footer', $this->data);
	}
	
	public function submit_content($name){
		$this->load->helper(array('html','form','url'));
		$lang = '_'.$this->lang->lang();
		$this->data['filename']='application/views/pages/'.$name.$lang.'.php';		
		if(file_exists($this->data['filename'])===TRUE){
			file_put_contents($this->data['filename'], $this->input->post('elm1'));
		}
		redirect(site_url().$this->lang->lang().'/admin/edit_content/'.$name);
	}
}