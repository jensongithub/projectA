<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Login extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper( array('form') );
		$this->load->library( 'form_validation' );
	}

	public function index(){
		$this->set_page('title', 'Login');
		$page = $this->get_session('page');
		$this->form_validation->set_rules('email', 'Email', 'email|required');
		$this->form_validation->set_rules('pwd', 'Password', 'required');
		
		
		$ret = $this->_auth();
		
		if (isset($_POST['cli']) && $this->input->post('cli')==="js"){
			// AJAX LOGIN FORM
			if ($ret === GO_TO_LOGIN_PAGE){
				echo "-1";
			}else if ($ret === GO_TO_ACTIVATE_PAGE){
				echo $this->load->view('account/warning/activation', $this->data);
			}else if ($ret === GO_TO_NEXT_PAGE){
				echo "200";
			}else if ($ret === GO_TO_INDEX_PAGE){
				echo "200";
			}
		}else{
			// NORMAL FORM POST
			if ($ret === GO_TO_LOGIN_PAGE){
				$this->load->view('templates/header', $this->data);
				$this->load->view('account/login_form', $this->data);
				$this->load->view('templates/footer');
			}else if ($ret === GO_TO_ACTIVATE_PAGE){
				$this->load->view('templates/header', $this->data);
				$this->load->view('account/warning/activation', $this->data);
				$this->load->view('templates/footer');
			}else if ($ret === GO_TO_NEXT_PAGE){
				redirect($page['next_page']);
			}
			else if ($ret === GO_TO_INDEX_PAGE){
				redirect($this->lang->lang()."/index");
			}
		}
	}
	
	public function _auth(){
		$flag = NULL;
		$user = array();
		$page = $this->get_session('page');
		
		if (($user=$this->user_model->authenticate_user())===FALSE){
			$flag = GO_TO_LOGIN_PAGE;  
		}
		else{
			$this->set_session('user', $user);			
			if (empty($user['activate_date'])){
				$flag = GO_TO_ACTIVATION_PAGE;
			}else{
				
				if (isset($page['next_page']) && !empty($page['next_page'])){
					$flag = GO_TO_NEXT_PAGE;
				}else{
					$flag = GO_TO_INDEX_PAGE;
				}
			}
		}
		return $flag;
	}
}
