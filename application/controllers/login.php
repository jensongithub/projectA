<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Login extends CI_Controller {

	public function __construct()	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index(){
		$data['title'] = 'Login';
		$this->load->helper( array('form') );
		$this->load->library('form_validation', 'session');
			
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		$this->load->view('templates/header', $data);
		if($this->form_validation->run() == FALSE) {
			$this->load->view('account/login_form', $data);
		}
		else {
			if ($this->user_model->authenicate_user()===FALSE){
				$this->load->view('account/login_form', $data);
			}
			else{
				$user = $this->user_model->get_user($user['email'], 'email');
				print_r($user);
				$session_items = array(
										'id' => $user['id'],
										'email' => $user['email']
									);
				$this->session->set_userdata($session_items);
				//redirect to previous page that requires login
				$this->load->view('account/', $data);
			}
		}
		$this->load->view('templates/footer');
	}
}
