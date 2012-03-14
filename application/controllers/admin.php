<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Admin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
	}

	public function index(){
		// require_login();		
		$data['title'] = 'Administration';
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/menu', $data);
		$this->load->view('admin/dashboard', $data);
		$this->load->view('admin/templates/footer', $data);
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
	
	public function edit_menu(){
		// require_login();
		
		$this->load->model('category_model');
		$this->load->model('menu_model');
		
		$data['title'] = 'Edit Menu';
		$this->load->library('form_validation');
		$this->load->helper('json');
		
		$data['menu'] = $this->menu_model->get_menu();
		$i = 1;
		foreach( $data['menu'] as $menu ){
			$data['menu_json']['mi' . $i] = $menu;
			$i++;
		}
		$data['menu_json'] = json_encode($data['menu_json']);
		$data['categories'] = $this->category_model->get_categories();
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/menu', $data);
		$this->load->view('admin/menu', $data);
		$this->load->view('admin/templates/footer', $data);
	}
	
	public function edit_products(){
		// require_login();
		
		$this->load->helper(array('form'));
		
		if( $this->input->post('upload') == '1' ){
			$config['upload_path'] = 'uploads/';
			$config['allowed_types'] = 'xls';
			$config['max_size']	= '1024';

			$this->load->library('upload', $config);
		
			if ( ! $this->upload->do_upload()) {
				$error = array('error' => $this->upload->display_errors());
				$this->load->view('admin/edit_products', $error);
			}
			else {
				$this->load->library('Excel_reader');
				$this->load->model('product_model');
				
				$this->excel_reader->setOutputEncoding('CP950');
				$data = array('upload_data' => $this->upload->data());
				$this->excel_reader->read( $data['upload_data']['full_path'] );
				
				$sheets = $this->excel_reader->sheets;
				$ns = count( $sheets );
				for($i = 0; $i < $ns; $i++){
					$sheets[$i]['name'] = $this->excel_reader->boundsheets[$i]['name'];
				}
				
				$this->product_model->add_product_in_excel_sheets( $sheets );
			}
		}
		
		$data['title'] = 'Edit products';
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/menu', $data);
		$this->load->view('admin/products', $data);
		$this->load->view('admin/templates/footer', $data);
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
		$data=array();
		$data['title']=$name;
		$data['view_name']=$name;
		$data['filename']="application/views/pages/".$name.'.php';
		$this->load->view('admin/editor', $data);
	}
}