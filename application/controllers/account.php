<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Account extends CI_Controller {
	var $data;
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		
	}

	public function index(){
		$this->data = array('title'=>'Account');
		$this->data = array_merge($this->data, $this->session->all_userdata());
		$lang = '_'.$this->lang->lang();
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/account'.$lang);
		$this->load->view('templates/footer');
	}
	
	public function update(){
		$user = $this->user_model->update_user($this->data['id']);
		if ($user!==FALSE){
			redirect('account/user_modify_success');
		}else{
			redirect('account/user_modify_failure');
		}
	}
}
