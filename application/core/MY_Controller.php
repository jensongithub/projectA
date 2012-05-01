<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class MY_Controller extends CI_Controller {
	// global variable for all pages.
	// set and get the session data
	// data['user'] = all user data
	// data['cart'] = all cart data
	// data['page_info'] = all page_info data 
	var $data = array();
	public function __construct()	{
		parent::__construct();
		// get session data, load it the the global data for the whole page to use
		
		$session_data = $this->session->all_userdata();		
		$this->data['user'] =array('is_login'=>FALSE);
		$this->data['page']['lang'] = $this->lang->lang();
		$this->data['user'] = isset($session_data['user']) ? array_merge($this->data['user'],$session_data['user']): array_merge($this->data['user'], $session_data);				
		$this->data['page'] = isset($session_data['page']) ? array_merge($this->data['page'],$session_data['page']): array_merge($this->data['page'], $session_data);
		$this->data['cart'] = isset($session_data['cart']) ? $session_data['cart']: array() ;
		
		$this->session->set_userdata($this->data);
	}
	
	public function require_login($role_id){
		if ($this->is_login()){
			// do nothing
			if ($this->data['user']['role_id'] != $role_id){
				redirect(site_url().$this->lang->lang()."/login");
			}
		}else{
			redirect(site_url().$this->lang->lang()."/login");
		}
	}
	
	public function set_page($attr, $value){
		$this->data['page'][$attr] = $value;
	}
	
	public function set_user($attr, $value){
		$this->data['user'][$attr] = $value;
	}
	
	public function set_cart($attr, $value){
		$this->data['cart'][$attr] = $value;
	}
	
	public function logout(){
		//$session_data = $this->session->all_userdata();
		//$this->session->unset_userdata('is_login');
		//$this->session->sess_destroy(); // session destroy with custom code!
		$this->data['user'] = array();
		$this->data['cart'] = array();
		$this->data['page'] = array();
		$this->session->unset_userdata($this->data);
		$this->session->sess_destroy(); // session destroy with custom code!
		redirect('index');
	}
	
	public function is_login(){
		$session_data = $this->session->all_userdata();
		return isset($session_data['user']['is_login']) && $session_data['user']['is_login']===TRUE;
	}	
}
