<?
/**
 * Code standard:
 * use the prefix "underscore" for internal function (Easy to identify the method type)
 * For both external and internal method, no prefix.
 * class Foo{
 * 		private function _internalMethod(){
 * 			//only use within the class
 * 		}
 *
 * 		public function publicMethod(){
 *
 * 		}
 *
 * 		protected function protectedMethod(){
 *
 * 		}
 * }
 **/

// developer only change the model for every new project
//include_once APPPATH.'libraries/loginLib.php';

class MyLoginLib {
	var $CI;
	var $id;
	var $email;

	function __construct(){
//		parent::__construct();
		$this->CI =& get_instance();
		$this->CI->load->database();
		$dataRules = array();
//		$dataRules["first_name"] = "XSS_CLEAN|TRIM|...";
//		$dataRules["last_name"] = "XSS_CLEAN|TRIM|...";
//		$dataRules["email"] = "XSS_CLEAN|TRIM|isEmail";

//		$this->dataRules = &$dataRules;
		$validUserSQL = "select firstname, lastname, pwd from users where username = ? ";
	}

	function submit(){

		$this->insert_user();
	}

	function insert_user(){
		$uid = mt_rand();
		$this->id = $uid;
		$this->email = 'davidrobinson91@hotmail.com';
		$this->CI->db->insert('user',$this);

	}
}


/*
abstract class LoginLib {

	function submit(){
		$flag = $this->validateData($_POST, $this->dataRules);
		if ($flag === TRUE){
			if ($this->Authenticate($username, $password)===TRUE){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}

	}

	function _validateData(){

	}

	function _isUniqueUsername(){

	}

	abstract function Authenticate($username, $password, $key=null);

	public function requireLogin($dest){
		if (!isLogin()){
			redirect("login");
		}
	}

	function isLogin(){

	}

	function logout(){

	}

	abstract function destroySession();

	abstract function createSession();

}
*/