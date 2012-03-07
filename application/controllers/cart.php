<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Sales extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
	}

	public function index(){
		$this->load->library('cart');
		
	}
	
	public function add(){
		$data = array(
               array(
                       'id'      => 'sku_123ABC',
                       'qty'     => 1,
                       'price'   => 39.95,
                       'name'    => 'T-Shirt',
                       'options' => array('Size' => 'L', 'Color' => 'Red')
                    ),
               array(
                       'id'      => 'sku_567ZYX',
                       'qty'     => 1,
                       'price'   => 9.95,
                       'name'    => 'Coffee Mug'
                    ),
               array(
                       'id'      => 'sku_965QRS',
                       'qty'     => 1,
                       'price'   => 29.95,
                       'name'    => 'Shot Glass'
                    )
            );

		$this->cart->insert($data); 
	}
}