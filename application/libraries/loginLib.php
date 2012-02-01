<?
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
?>