<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Testmssql extends CI_Controller {
	
	public function __construct()	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper( array('form') );
		$this->load->library('form_validation', 'session');
	}

	public function index(){
		$data['title'] = 'Login';
		$result = $this->common_model->test();
		print_r($result);

		$this->load->view('admin/templates/footer');
	}
}
