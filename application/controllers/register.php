<?php
class Register extends CI_Controller {
	
	public function __construct()	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index()	{
		$data['title'] = 'Register';
		
		$this->load->helper( array('form') );
		$this->lang->load('register');
		$this->load->library('form_validation', 'session');
		
		$this->load->view('templates/header', $data);
		if($this->form_validation->run() == FALSE) {
			$this->load->view('account/register_form', $data);
		}
		else {
			$user = $this->user_model->insert_user();
			$user = $this->user_model->get_user($user['email'], 'email');
			print_r($user);
			$session_items = array(
									'id' => $user['id'],
									'email' => $user['email']
								);
			$this->session->set_userdata($session_items);
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