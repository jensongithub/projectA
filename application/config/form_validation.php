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
			'rules' => 'trim|required|xss_clean'
		),
		array(
			'field' => 'lastname',
			'label' => 'lang:lastname',
			'rules' => 'trim|required|xss_clean'
		),
		array(
			'field' => 'pwd',
			'label' => 'lang:pwd',
			'rules' => 'trim|required|min_length[8]|md5'
		),
		array(
			'field' => 'conpwd',
			'label' => 'lang:conpwd',
			'rules' => 'trim|required|matches[pwd]'
		),
		array(
			'field' => 'phone',
			'label' => 'lang:phone',
			'rules' => 'trim'
		),
		array(
			'field' => 'gender',
			'label' => 'lang:gender',
			'rules' => 'required'
		)
	),
	'admin/edit_categories' => array(
		array(
			'field' => 'catname',
			'label' => 'lang:catname',
			'rules' => 'required|is_unique[categories.name]'
		)
	)
);