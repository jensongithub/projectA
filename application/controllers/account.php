<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Account extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		
		$this->require_login();

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
	
	public function history($order_id=null){
	
		$this->load->helper( array('form') );
		//$this->load->library('form_validation');
		
		$row_num = 0;
		$howmany = 15;
		$conditions=array('users.id'=>$this->data['user']['id']);
		
		$this->data['page']['title']='Purchase History';
		$this->load->model(array('product_model','order_model'));
		
		$this->data['page']['query_url'] = site_url().$this->lang->lang()."/admin/history_search/";
		//$this->data['page']['save_url'] = site_url().$this->lang->lang()."/admin/order_save/";
		
		//$this->order_model->get_orders_by_user_id($this->data['user']['id']);
		
		
		// when the user click click an order and wants to see the order items
		if ($this->input->post()===FALSE){
			if ($order_id!==null){
				$conditions = array('orders.id'=>$order_id);
				$order_detail = $this->order_model->get_order_items_by_id($order_id);
				$this->data['page']['order_items'] = &$order_detail;
			}
			$offset_row = $row_num;
		}else{
				$row_num = $this->input->post('_row_num');			
				$howmany = $this->input->post('howmany');
				$offset_row = $row_num*$howmany;
				
				
				//$query_key_pairs = $this->input->post('val');
				//$conditions = array_merge($conditions, json_decode($query_key_pairs, true));
				
				
				// ensure the current user, not override by other users
				$conditions['users.id']=$this->data['user']['id'];
		}
		
		$order = $this->order_model->get_order_by_status($conditions, $offset_row, $howmany);
		list($total_rows) = $this->order_model->get_orders_cnt_by_user_id($conditions);
		
		$this->data['page']['order'] = &$order;		
		
		$this->data['page']['total_page_num'] = ceil($total_rows['cnt']/$howmany);
		$this->data['page']['curr_page_num'] = $row_num+1;
		$this->data['page']['total_row'] = $total_rows['cnt'];
		
		$this->load->view('templates/header', $this->data);
		$this->load->view('account/order_history', $this->data);
		$this->load->view('templates/footer', $this->data);
	}
}
