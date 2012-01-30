<?php
class Login extends CI_Controller {

	public function __construct()	{
		parent::__construct();
		$this->load->model('login_model');
	}

	public function submit(){
		// the login logic is implemented inside the model
		// keep the controller simple and clean
		$this->login_model->submit($_POST);
	}

	public function index(){

		$this->load->view('login');
	}

}
