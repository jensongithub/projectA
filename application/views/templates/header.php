<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<title><?php echo sprintf("Casimira - %s", _($title)); ?></title>
	<?php echo css('style.css'); ?>
	<script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
</head>
<body>
<div>
	<div class='menu_lang'>
		<ul>

		</ul>
	</div>	
	<div class='menu_l1'>
		<ul>
			<?php echo ($this->common_model->is_login()===FALSE) ? '': '<li>'.anchor('account', "Hello, $firstname").'</li>';?>
			<li><?php echo anchor($this->lang->switch_uri('en'), '<span class="">Eng</span>'); ?></li>
			<li><?php echo anchor($this->lang->switch_uri('zh'), '<span class="">繁</span>'); ?></li>
			<li><?php echo anchor($this->lang->switch_uri('cn'), '<span class="">簡</span>'); ?></li>
			<li><a href='http://www.facebook.com/pages/Casimira/326940370663389' target='_blank'><img class='fb_logo' src='/images/f_logo.png' /></a></li>
			<li><?php echo anchor('cart', "<img class='fb_logo' src='/images/cart.png' />") ?><span class='cart_counter'></span></li>
			<li><?php echo ($this->common_model->is_login()===FALSE) ? anchor('login', _('Login')) : anchor('logout', _('Logout')) ?></li>
		</ul>
	</div>
	<div><a href="/"><img class='logo' src="/images/logo.png" alt=""/></a></div>
	<div class='menu_l2'>
		<ul>
			<li><?php echo anchor('company', _('About us')); ?> / </li>			
			<li><?php echo anchor('browse/women/sales', _('Ladies')); ?> / </li>
			<li><?php echo anchor('', _('Men')); ?> / </li>
			<li><?php echo anchor('', _('Accessories')); ?> / </li>
			<li><?php echo anchor('sales', _('Sales')); ?> / </li>
			<li><?php echo anchor('news', _('News')); ?> / </li>
			<li><?php echo anchor('info#location', _('Location')); ?> / </li>
			<li><?php echo anchor('product_care', _('Product Care')); ?> / </li>
			<li><?php echo anchor('info#contact', _('Contact us')); ?></li>
		</ul>
	</div>
</div>
<div id="content" class="container">
	<div class="container">
