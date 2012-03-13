<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Login extends CI_Controller {
	
	public function __construct()	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper( array('form') );
		$this->load->library('form_validation', 'session');
	}

	public function index(){
		$data['title'] = 'Login';		
		
		$this->form_validation->set_rules('email', 'Email', 'email|required');
		$this->form_validation->set_rules('pwd', 'Password', 'required');
		
		$this->load->view('templates/header', $data);
		
		if($this->form_validation->run() == FALSE) {
			$this->load->view('account/login_form', $data);
		}
		else {
			if (($user=$this->user_model->authenticate_user())===FALSE){
				$this->load->view('account/login_form', $data);
			}
			else{
				$this->session->set_userdata($user);
				$nextPage = $this->input->post('nextPage') =='' ? 'index': $this->input->post('nextPage');
				redirect('index');
			}
		}
		$this->load->view('templates/footer');
	}
}
