<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Account extends CI_Controller {
	var $data = array();
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('email');
		$this->data = array_merge($this->data, $this->session->all_userdata());
	}

	public function index()	{
		$this->data['title'] = 'Account';
		$this->load->library('form_validation', 'session');

		$this->load->view('templates/header', $this->data);
		if($this->form_validation->run() === FALSE) {
			$this->load->view('account/info_form', $this->data);
		}
		else {
			$user = $this->user_model->update_user($this->data['id']);
			$user = $this->user_model->get_user($this->data['email'], 'email');
			$session_items = array(
									'id' => $user['id'],
									'email' => $user['email'],
									'firstname' => $user['firstname'],
									'lastname' => $user['lastname'],
									'phone' => $user['phone']
									
								);
			$this->session->set_userdata($session_items);
			$this->data['success'] = TRUE;
			$this->load->view('account/info_form', $this->data);
		}
		$this->load->view('templates/footer');
	}
	
}
