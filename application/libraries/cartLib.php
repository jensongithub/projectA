<?
class Cart{

	function __construct(){
		/**
		 * sc - shopping cart
		 * shopping cart session is created on the client side only.
		 * database will not save the shopping cart data
		 **/
		$this->_setSession("sc", array());
	}

	function checkout(){
		// user checkout cart. Submit data to server and start payment

	}

	private function _payment(){

	}

	function _setSession($name, $data){

	}

	function _sendConfirmMail($recipient){

	}

	function getInvoice(){

	}
}
