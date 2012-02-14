<?php

class Pages extends CI_Controller {

	public function view($page = 'home', $var = '') {
		if ( ! file_exists('application/views/pages/'.$page.'.php')){
			// Whoops, we don't have a page for that!
			show_404();
		}

		$data['title'] = ucfirst($page); // Capitalize the first letter

		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}

	public function women($cat = 'sweaters') {
		if ( ! file_exists('application/views/pages/women.php')){
			// Whoops, we don't have a page for that!
			show_404();
		}

		$data['title'] = ucfirst('women'); // Capitalize the first letter
		$data['cat'] = ucfirst($cat);

		switch($cat){
			case 'cardigans':
				$data['products'][] = 'DSL420-2a.jpg';
				$data['products'][] = 'IMG_2511a.jpg';
				$data['products'][] = 'IMG_2525a.jpg';
				$data['products'][] = 'IMG_2556a.jpg';
				$data['products'][] = 'IMG_2559a.jpg';
				break;
			case 'crewnecks':
				$data['products'][] = 'DSL272-5a.jpg';
				$data['products'][] = 'DSL421-5a.jpg';
				$data['products'][] = 'DSL424-1a.jpg';
				$data['products'][] = 'DSL424-3a.jpg';
				$data['products'][] = 'DSL433-1a.jpg';
				$data['products'][] = 'DSL499-4a.jpg';
				$data['products'][] = 'IMG_2500a.jpg';
				$data['products'][] = 'IMG_2533a.jpg';
				$data['products'][] = 'IMG_2543a.jpg';
				break;
			case 'sweaters':
				$data['products'][] = 'DSL420-2a.jpg';
				$data['products'][] = 'IMG_2525a.jpg';
				$data['products'][] = 'IMG_2559a.jpg';
				$data['products'][] = 'DSL272-5a.jpg';
				$data['products'][] = 'IMG_2511a.jpg';
				$data['products'][] = 'DSL421-5a.jpg';
				$data['products'][] = 'DSL424-1a.jpg';
				$data['products'][] = 'DSL424-3a.jpg';
				$data['products'][] = 'DSL433-1a.jpg';
				$data['products'][] = 'DSL499-4a.jpg';
				$data['products'][] = 'IMG_2500a.jpg';
				$data['products'][] = 'IMG_2556a.jpg';
				$data['products'][] = 'IMG_2533a.jpg';
				$data['products'][] = 'IMG_2543a.jpg';
				break;
		}

		$this->load->view('templates/header', $data);
		$this->load->view('pages/women', $data);
		$this->load->view('templates/footer', $data);
	}
}