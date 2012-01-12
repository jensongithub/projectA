<?php
class Categories extends CI_Controller {

	public function __construct()	{
		parent::__construct();
		$this->load->model('categories_model');
	}

	public function index()	{
		$data['category'] = $this->news_model->get_category();
		$data['title'] = 'Categories archive';

		$this->load->view('templates/header', $data);
		$this->load->view('news/index', $data);
		$this->load->view('templates/footer');
	}

	public function view($id) {
		$data['cat_item'] = $this->categories_model->get_category($id);
		
		if (empty($data['cat_item'])) {
			show_404();
		}

		$data['title'] = $data['cat_item']['name'];
		$data['layout']['list'] = $this->list_cat($id);

		$this->load->view('templates/header', $data);
		$this->load->view('categories/view', $data);
		$this->load->view('templates/footer');
	}
	
	public function list_cat($id = "") {
		$data['cat_item'] = $this->categories_model->get_category();
		
		if (empty($data['cat_item'])) {
			show_404();
		}

		return $this->load->view('categories/list', $data, true);
	}
}