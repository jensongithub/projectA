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
		$this->data['user'] = array('is_login'=>FALSE);
		$this->data['page'] = array('lang' =>$this->lang->lang());
		$this->data['user'] = isset($session_data['user']) ? array_merge($this->data['user'],$session_data['user']): $this->data['user'];
		$this->data['page'] = isset($session_data['page']) ? array_merge($this->data['page'],$session_data['page']): $this->data['page'];
		$this->data['cart'] = isset($session_data['cart']) ? $session_data['cart']: array() ;
		
		$this->session->set_userdata($this->data);
	}

	function set_session($name, $value){
		$session_data = $this->session->all_userdata();
		//$session_data[$name] = $value;
		$session_data[$name] = array_merge($session_data[$name], $value);
		$this->session->set_userdata($session_data);
	}
	
	function get_session($name=""){
		if ($name===""){
			$session_data = $this->session->all_userdata();
		}else{
			$session_data = $this->session->userdata($name);
		}		
		return $session_data;
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

	public function require_login($role_id=1,$next_page=""){
		$this->load->helper( array('form') );
		$this->load->library('form_validation');
		
		$is_valid = FALSE;
		
		$session_data = $this->session->all_userdata();
		
		if (isset($session_data['user']['is_login']) && $session_data['user']['is_login']===TRUE && 
			($session_data['user']['role_id'] == $role_id || 
			 $session_data['user']['role_id'] == ADMIN_ROLE)
			)
		{
			$is_valid = TRUE;
		}
		
		
		if ($this->input->post('cli')==="js"){
			$session_data['page']['next_page'] = $this->input->post('redirect');
			$this->session->set_userdata($session_data);
			
			if ($is_valid){
				echo <<<JS_SCRIPT
				{"code":"200", "url":""}
JS_SCRIPT;
			}
			else{
				$url = site_url().$this->lang->lang()."/login";
				echo <<<JS_SCRIPT
					{"code":"-999", "url":"$url"}
JS_SCRIPT;
			}
		}else{			
			$session_data['page']['next_page'] = empty($next_page)? current_url(): $next_page;
			$this->session->set_userdata($session_data);			

			if ($is_valid){
				if ($session_data['page']['next_page'] != current_url()) redirect($session_data['page']['next_page']);
			}else{
				redirect('login');
			}
		}
	}
	
}
