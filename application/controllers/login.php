<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Login extends CI_Controller {

	public function __construct()	{
		parent::__construct();
//		$this->load->model('login_model');
//		$this->load->library('MyLoginLib');
		$this->load->model('login_modellib');
		$this->load->helper('url');
	}

	public function submit(){
		// the login logic is implemented inside the model
		// keep the controller simple and clean
		//redirect('index');
//		$this->myloginlib->submit();
		$this->login_modellib->submit();


	}

	public function index(){
		$data['title'] = 'Login';
		$this->load->view('templates/header', $data);
		$this->load->view('account/login');
		$this->load->view('templates/footer');
	}

	public function url($dest){

	}

}
