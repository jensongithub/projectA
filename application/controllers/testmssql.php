<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Testmssql extends CI_Controller {
	
	public function __construct()	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper( array('form') );
		$this->load->library('form_validation', 'session');
	}

	public function index(){
		$data['title'] = 'Login';
		$result = $this->common_model->load_products_to_web_store();
		//$result = $this->common_model->test();
		$i = 0;
		foreach($result as $row){
			echo "<p>Row $i<br />";
			foreach($row as $key => $value){
				echo "[$key] => $value ";
			}
			echo "</p>";
			$i++;
		}

		$this->load->view('admin/templates/footer');
	}
	
	public function check(){
		$result = $this->common_model->check_stock();
		
		if(is_array($result)){
			$i = 0;		
			foreach($result as $row){
				echo "<p>Row $i<br />";
				foreach($row as $key => $value){
					echo "[$key] => $value ";
				}
				echo "</p>";
				$i++;
			}
		}
	}
	
	public function color(){
		$result = $this->common_model->load_color();
		
		if(is_array($result)){
			$i = 0;
			foreach($result as $row){
				echo "<p>Row $i<br />";
				foreach($row as $key => $value){
					echo "[$key] => $value ";
				}
				echo "</p>";
				$i++;
			}
		}
	}

	public function load(){
		$data['title'] = 'Login';
		$result = $this->common_model->load_products_to_web_store();
		$i = 0;
		foreach($result as $row){
			echo "<p>Row $i<br />";
			foreach($row as $key => $value){
				echo "[$key] => $value ";
			}
			echo "</p>";
			$i++;
		}

		$this->load->view('admin/templates/footer');
	}
}
