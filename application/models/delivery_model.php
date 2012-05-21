<?php
class Delivery_model extends CI_Model {
	var $CI;
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->CI =& get_instance();
	}
	
	public function get_charge_by_country_code($src_country_code, $dest_country_code, $currency){
		$charge_currency = '';
		if (preg_match('/HKD|RMB|USD/i', $currency)){
			$charge_currency = $currency;
		}else{
			$charge_currency = 'hkd';
		}
		$query = "select $charge_currency from delivery_charge where src_country_code = ? and country_code = ?";
		$query = $this->db->query($query, array($src_country_code, $dest_country_code));
		
		return $query->result_array();
		
	}
}