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


class MyLoginLib {
	var $CI;
	var $id;
	var $email;

	public function __construct(){

		$this->CI =& get_instance();
		$this->CI->load->database();
		$dataRules = array();

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

?>