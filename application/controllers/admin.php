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
		$this->load->library('Excel_reader');
		$this->excel_reader->setOutputEncoding('CP950');
		$this->excel_reader->read('uploads/test.xls');
		
		$this->load->helper(array('form'));
		
		foreach( $this->excel_reader->sheets as $key => $sheet){
			print_r($sheet);
			echo "<br/>";
			echo $this->excel_reader->boundsheets[$key]['name'] . ": ";
			echo "<br/>";
			for ($i = 1; $i <= $this->excel_reader->sheets[$key]['numRows']; $i++) {
				echo "Line $i: {";
				for ($j = 1; $j <= $this->excel_reader->sheets[$key]['numCols']; $j++) {
					if( isset($this->excel_reader->sheets[$key]['cells'][$i]) && isset($this->excel_reader->sheets[$key]['cells'][$i][$j]) )
						echo "\"".$this->excel_reader->sheets[$key]['cells'][$i][$j]."\", ";
					else
						echo "\"\", ";
				}
				echo "}<br />\n";
			}
			echo "<br/>";
		}
		
		$data['title'] = 'Edit products';
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/templates/menu', $data);
		$this->load->view('admin/products', $data);
		$this->load->view('admin/templates/footer', $data);
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