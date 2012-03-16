<?php
class News extends CI_Controller {
	var $data;
	public function __construct()	{
		parent::__construct();
		$this->load->model('news_model');
	}
	
	
	public function index(){
		$data = array('title'=>'News');
		$data = array_merge($data, $this->session->all_userdata());
		$lang = '_'.$this->lang->lang();
		$this->load->view('templates/header', $data);
		$this->load->view('pages/news'.$lang);
		$this->load->view('templates/footer');
	}
	
	/*
	public function index()	{
		$this->data['news'] = $this->news_model->get_news();
		$this->data['title'] = 'News archive';
		$this->data = array_merge($this->data, $this->session->all_userdata());
		$this->load->view('templates/header', $this->data);
		$this->load->view('news', $this->data);
		$this->load->view('templates/footer');
	}

	public function view($slug) {
		$this->data['news_item'] = $this->news_model->get_news($slug);

		if (empty($this->data['news_item'])) {
			show_404();
		}

		$this->data['title'] = $this->data['news_item']['title'];

		$this->load->view('templates/header', $this->data);
		$this->load->view('news/view', $this->data);
		$this->load->view('templates/footer');
	}
	*/
}