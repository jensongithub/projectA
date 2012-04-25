<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Login extends CI_Controller {
	var $data = array();
	public function __construct()	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper( array('form') );
		$this->load->library('form_validation');
		$this->data = array_merge($this->data, $this->session->all_userdata());
		$this->data['cart_counter'] = isset($this->data['cart'])? count($this->data['cart']) : 0;
	}

	public function index(){
		$this->data['title'] = 'Login';		
		
		$this->form_validation->set_rules('email', 'Email', 'email|required');
		$this->form_validation->set_rules('pwd', 'Password', 'required');
		
		$this->load->view('templates/header', $this->data);
		if($this->form_validation->run() == FALSE) {
			$this->load->view('account/login_form', $this->data);
		}
		else {
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
