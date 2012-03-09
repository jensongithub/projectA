<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Worker extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		// require_login();
	}
	
	public function update_menu(){
		// require_login();
		
		$this->load->model('menu_model');
		$item['cat_id'] = $this->input->post('cat_id');
		$item['text'] = $this->input->post('text');
		$item['path'] = $this->input->post('path');
		$item['level'] = $this->input->post('level');
		if( !$this->menu_model->get_menu_item($item['cat_id']) ){
			if( $this->menu_model->add_menu_item($item) )
				echo 'OK';
			else
				echo 'FAIL';
		}
		else {
			if( $this->menu_model->edit_menu_item($item) )
				echo 'OK';
			else
				echo 'FAIL';
		}
	}
}