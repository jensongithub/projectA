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

class LoginLib {

	protected $dataRules;

	function submit(){
		$flag = $this->validateData($_POST, $this->dataRules);
		if ($flag === TRUE){
			if ($this->authenticate($username, $password)===TRUE){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}


	function _validateData(){

	}

	function _isUniqueUsername(){

	}

	function authenticate($username, $password, $key=null){
		$this->_DBAuthenicticate($username, $password, $key);
	}

	abstract function _DBAuthenicticate($username, $password, $key=null){}

	public function requireLogin(){
		if (!isLogin()){
			redirect("login");
		}else{
			redirect(site_url());
		}
	}

	function isLogin(){

	}

	function logout(){

	}

	abstract function destroySession(){

	}

	abstract function createSession(){

	}

}

