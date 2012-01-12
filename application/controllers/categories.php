<?php
class Categories extends CI_Controller {

	public function __construct()	{
		parent::__construct();
		$this->load->model('categories_model');
	}

	public function index()	{
		$data['category'] = $this->news_model->get_categories();
		$data['title'] = 'Categories archive';

		$this->load->view('templates/header', $data);
		$this->load->view('news/index', $data);
		$this->load->view('templates/footer');
	}

	public function view($id) {
		$data['cat_item'] = $this->categories_model->get_categories($id);
		
		if(empty($data['cat_item'])) {
			show_404();
		}
		
		/*
		if( $data['cat_item']['parent'] != NULL ) {
			do{
				$data['path'][] = $this->categories_model->get_category_parent($id);
				$end = end($data['path']);
				$id = $end['id'];
			} while( $end['parent'] != NULL );
		}
		*/

		$data['title'] = $data['cat_item']['name'];
		$data['layout']['list'] = $this->list_cat($id);

		$this->load->view('templates/header', $data);
		$this->load->view('categories/view', $data);
		$this->load->view('templates/footer');
	}
	
	public function list_cat($id = "") {
		$data = $this->build_cat_list_array();
		
		if (empty($data['cat'])) {
			show_404();
		}

		return $this->load->view('categories/list', $data, true);
	}
	
	public function build_cat_list_array($id = false) {
		$temp['cat'] = array();
		if($id === false) {
			$temp['cat'] = $this->categories_model->get_categories_by_parent();
			// echo "get_categories_by_parent(), get the top categories.<br />";
		}
		else {
			$temp['cat'] = $this->categories_model->get_categories_by_parent($id);
			// echo "get_categories_by_parent($id).<br />";
		}
		
		if( empty($temp['cat']) )
			return null;

		foreach( $temp['cat'] as $cat){
			$data['cat'][] = array();
			$index = count($data['cat']) - 1;
			$data['cat'][$index]['itself'] = $cat;
			$temp['child'] = $this->build_cat_list_array($cat['id']);
			$data['cat'][$index]['child'] = $temp['child']['cat'];
		}
		return $data;
	}
}