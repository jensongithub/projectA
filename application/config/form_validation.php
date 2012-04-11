<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
	'register/index' => array(
		array(
			'field' => 'email',
			'label' => 'lang:email',
			'rules' => 'required|valid_email|is_unique[users.email]'
		),
		array(
			'field' => 'firstname',
			'label' => 'lang:firstname',
			'rules' => 'trim|required|min_length[1]|max_length[50]|xss_clean'
		),
		array(
			'field' => 'lastname',
			'label' => 'lang:lastname',
			'rules' => 'trim|required|min_length[1]|max_length[50]|xss_clean'
		),
		array(
			'field' => 'pwd',
			'label' => 'lang:pwd',
			'rules' => 'trim|required|min_length[8]|max_length[16]'
		),
		array(
			'field' => 'conpwd',
			'label' => 'lang:conpwd',
			'rules' => 'trim|required|matches[pwd]'
		),
		array(
			'field' => 'phone',
			'label' => 'lang:phone',
			'rules' => 'trim|min_length[3]|max_length[16]'
		),
		array(
			'field' => 'gender',
			'label' => 'lang:gender',
			'rules' => 'required'
		)
	),
	
	'account/index' => array(
		array(
			'field' => 'pwd',
			'label' => 'lang:pwd',
			'rules' => 'trim|required|min_length[8]|max_length[16]'
		),
		array(
			'field' => 'conpwd',
			'label' => 'lang:conpwd',
			'rules' => 'trim|required|matches[pwd]'
		),
		array(
			'field' => 'phone',
			'label' => 'lang:phone',
			'rules' => 'trim|min_length[3]|max_length[16]'
		)
	)
);