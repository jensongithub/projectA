<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Account extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('email');	
	}

	public function index()	{
		$this->set_page('title','Account');
		
		$this->load->library('form_validation', 'session');

		$this->load->view('templates/header', $this->data);
		if($this->form_validation->run() === FALSE) {
			$this->load->view('account/info_form', $this->data);
		}
		else {
			$user = $this->user_model->update_user($this->data['user']['id']);
			$user = $this->user_model->get_user($this->data['user']['email'], 'email');
			$_session_data = array(
									'id' => $user['id'],
									'email' => $user['email'],
									'firstname' => $user['firstname'],
									'lastname' => $user['lastname'],
									'phone' => $user['phone']
									
								);
			
			$session_data = $this->session->all_userdata();
			$session_data['user'] = $_session_data;
			$this->session->set_userdata($session_data);
			
			$this->data['page']['success'] = TRUE;
			$this->load->view('account/info_form', $this->data);
		}
		$this->load->view('templates/footer');
	}
	
	public function forgotten(){
		$this->set_page('title','Forgotten');
		
		$this->load->library('form_validation', 'session');		
		$this->form_validation->set_rules('email', 'Email', 'email|required');
		
		$this->load->view('templates/header', $this->data);
		if($this->form_validation->run() == FALSE) {
			$this->load->view('account/forgotten_form', $this->data);
		}
		else {
			$user = $this->user_model->get_user($this->input->post('email'),'email');
			
			if (!empty($user)){
				$user['activate_code']=$this->user_model->reset_password_by_email($user['email']);
				$message = $this->load->view('account/mail_forgotten', array('user'=>$user), true);
				$this->email->send_forgotten_mail($user, "Casimira User Reset Password", $message);
			}
			$this->data['user'] = &$user;
			$this->load->view('account/forgotten_redirect', $this->data);
		}
		$this->load->view('templates/footer');
	}
	
	public function reset_password($email, $activate_code){
		/**
		 * reset password link
		 */
		$this->set_page('title','Forgotten');
		$this->load->library('form_validation', 'session');		
		$this->form_validation->set_rules('email', 'Email', 'email|required');
		
		$user = $this->user_model->get_user($email, 'email');
		
		$user=$this->user_model->authenticate_user_by_email(rawurldecode($email), $activate_code);
		
		$this->data['user'] = &$user;
		$this->load->view('templates/header', $this->data);
		$this->load->view('account/reset_password_form');
		$this->load->view('templates/footer');
	}
	
	public function new_password(){	
		$this->load->library('form_validation', 'session');
		$this->form_validation->set_rules('pwd', 'Password', 'required');
		
		$this->load->view('templates/header', $this->data);
		
		if($this->form_validation->run()) {
			$user=array();
			$user['pwd'] = md5($this->input->post('pwd'));			
			$user = $this->user_model->update_user($this->data['user']['id'], $user);
			$this->data['user'] = $this->user_model->get_user($this->data['email'], 'email');
			
			$session_data = $this->session->all_userdata();
			$this->data['user'] = array_merge($this->data['user'], $session_data['user']);
			$this->data['page']['success'] = TRUE;
			
			$this->load->view('account/user_update_success', $this->data);
		}
		$this->load->view('templates/footer');
	}
	
	public function warning($message){
		$this->load->view('templates/header', $this->data);
		if ($message === "activation"){
			$this->load->view('account/warn_activation', $this->data);
		}else if ($message === "expired"){ 
			$this->load->view('account/warn_expired', $this->data);
		}
		
		$this->load->view('templates/footer');
	}
}
