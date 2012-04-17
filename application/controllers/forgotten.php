<?php
class Forgotten extends CI_Controller {
	var $data=array();
	public function __construct()	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('email');
		$this->data = array_merge($this->data, $this->session->all_userdata());
	}

	public function index()	{
		$data['title'] = 'Register';
		
		$this->load->helper( array('form') );
		//$this->lang->load('register');
		$this->load->library('form_validation', 'session');
		
		$this->load->view('templates/header', $data);
		if($this->form_validation->run() === FALSE) {
			$this->load->view('account/register_form', $data);
		}
		else {
			$user = $this->user_model->insert_user();
			$user = $this->user_model->get_user($user['email'], 'email');			
			$user['raw_password'] =$this->input->post('pwd');			
			
			$message = $this->load->view('account/mail_forgotten', array('user'=>$user), true);
			//echo $message;
			//exit();
			$this->email->send_activate_mail($user, "Casimira New Password", $message);
			
			$session_items = array(
									'id' => $user['id'],
									'email' => $user['email'],
									'firstname' => $user['firstname'],
									'lastname' => $user['lastname'],
									'phone' => $user['phone'],
									'gender' => $user['gender']
								);
			$this->session->set_userdata($session_items);
			
			$this->load->view('account/register_finish', $this->data);
		}
		$this->load->view('templates/footer');
	}
	
	public function activate($email, $activate_code) {
		$this->user_model->activate_user(rawurldecode($email), $activate_code);
	}
}