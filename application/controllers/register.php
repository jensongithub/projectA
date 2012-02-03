<?php
class Register extends CI_Controller {
	
	public function __construct()	{
		parent::__construct();
		$this->load->model('register_model');
	}

	public function index()	{
		$data['title'] = 'Register';
		
		$this->load->helper('form');
		
		$this->load->view('templates/header', $data);
		$this->load->view('account/register_form', $data);
		$this->load->view('templates/footer');
	}
	
	public function submit() {
		$this->register_model->insert_user();
	}
}