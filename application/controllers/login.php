<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Login extends CI_Controller {

	public function __construct()	{
		parent::__construct();
		//$this->load->model('login_model');
		//$this->load->library('MyLoginLib');
		$this->load->helper('url');
	}

	public function submit(){
		// the login logic is implemented inside the model
		// keep the controller simple and clean
		//redirect('index');
		$this->myloginlib->submit();

	}

	public function index(){
		$this->load->view('login');
	}

	public function url($dest){

	}

}
