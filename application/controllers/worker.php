<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Worker extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		// require_login();
	}
	
	public function edit_categories(){
		// require_login();
		
		$this->load->model('category_model');
		
		$data['title'] = 'Edit categories';
		$data['action'] = '';
		
		$this->load->library('form_validation');
		
		if( $this->input->post('action') == 'add' ){
			$this->form_validation->set_rules('catname-a', 'Category name', 'trim|required|is_unique[categories.name]');
			$this->form_validation->set_message('required', '%s cannot be empty');
			$this->form_validation->set_message('is_unique', '%s already exist');
			if( $this->form_validation->run() == TRUE ) {
				$this->category_model->add_category( $this->input->post('catname-a') );
			}
			else{
				$data['action'] = 'add';
			}
		}
		else if( $this->input->post('action') == 'edit' ){
			$this->form_validation->set_rules('ori-catname', 'Original category name', 'min_length[1]');
			$this->form_validation->set_rules('catname-e', 'Category name', 'trim|required|is_unique[categories.name]');
			$this->form_validation->set_rules('catid', 'Category ID', 'trim|required|integer');
			$this->form_validation->set_message('required', '%s cannot be empty');
			$this->form_validation->set_message('is_unique', '%s already exist');
			if( $this->form_validation->run() == TRUE ) {
				$this->category_model->edit_category( $this->input->post('catid'), $this->input->post('catname-e') );
			}
			else{
				$data['action'] = 'edit';
			}
		}
		
		$data['categories'] = $this->category_model->get_categories();
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/menu', $data);
		$this->load->view('admin/categories', $data);
		$this->load->view('admin/templates/footer', $data);
	}
	
	public function update_menu(){
		// require_login();
		
		$this->load->model('menu_model');
		$item['cat_id'] = $this->input->post('cat_id');
		$item['text'] = $this->input->post('text');
		$item['path'] = $this->input->post('path');
		$item['level'] = $this->input->post('level');
		if( !$this->menu_model->get_menu_item($item['cat_id']) ){
			if( $this->menu_model->add_menu_item($item) )
				echo 'OK';
			else
				echo 'FAIL';
		}
		else {
			if( $this->menu_model->edit_menu_item($item) )
				echo 'OK';
			else
				echo 'FAIL';
		}
	}
	
	public function upload_product_list(){
		// require_login();
		
		$this->load->helper(array('form'));
		
		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'xls';
		$config['max_size']	= '1024';

		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload()) {
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('admin/products', $error);
		}
		else {
			$data = array('upload_data' => $this->upload->data());

			$this->load->view('admin/products', $data);
		}
	}
	
	public function read(){
	
		$lines = file('women.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

		// Loop through our array, show HTML source as HTML source; and line numbers too.
		foreach ($lines as $line_num => $line) {
			echo "<p>INSRET INTO categories (name) VALUES ('WOMEN -> $line');</p>";
			$this->category_model->add_category('WOMEN -> ' . $line);
		}
	}
}