<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Login extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper( array('form') );
		$this->load->library('form_validation');
	}

	public function index(){
		$this->set_page('title', 'Login');
		
		$this->form_validation->set_rules('email', 'Email', 'email|required');
		$this->form_validation->set_rules('pwd', 'Password', 'required');
		
		$this->load->view('templates/header', $this->data);
		if($this->form_validation->run() == FALSE) {
			$this->load->view('account/login_form', $this->data);
		}
		else {
			$user = array();
			if (($user=$this->user_model->authenticate_user())===FALSE){
				$this->load->view('account/login_form', $this->data);
			}
			else{
				//$nextPage = $this->input->post('nextPage') =='' ? 'index': $this->input->post('nextPage');
				if (empty($user['activate_date'])){
					redirect("account/warning/activation");
				}else{
					redirect('index');
				}
			}
		}
		$this->load->view('templates/footer');
	}
}
