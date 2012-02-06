<?php
class Register extends CI_Controller {
	
	public function __construct()	{
		parent::__construct();
		$this->load->model('register_model');
	}

	public function index()	{
		$data['title'] = 'Register';
		
		$this->load->helper( array('form') );
		$this->lang->load('register');
		$this->load->library('form_validation');
		
		$this->load->view('templates/header', $data);
		if($this->form_validation->run() == FALSE) {
			$this->load->view('account/register_form', $data);
		}
		else {
			//$this->register_model->insert_user();
			$this->load->view('account/register_finish', $data);
		}
		$this->load->view('templates/footer');
	}
	
	public function test() {
		$data['title'] = 'Register';
		$this->load->view('templates/header', $data);
		echo $this->lang->lang();
	}
}