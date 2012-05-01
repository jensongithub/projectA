<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Worker extends MY_Controller {
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
		$item['text_zh'] = $this->input->post('text_zh');
		$item['text_cn'] = $this->input->post('text_cn');
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
	
	public function get_components($needle = ''){
		$this->load->model('component_model');
		$data = $this->component_model->search_by_name($needle);
		echo json_encode($data);
	}
}