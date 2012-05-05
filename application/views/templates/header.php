<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<title><?php echo sprintf("Casimira - %s", _($page['title'])); ?></title>
	<?php echo css('style.css'); ?>
	<script type='text/javascript' src="/js/jquery.min.js"></script>
	<script type='text/javascript' src='/js/cart.js'></script>
	<script type='text/javascript' src="/js/common.js"></script>
</head>
<body>
<div>
	<div class='menu_lang'>
		<ul>

		</ul>
	</div>	
	<div class='menu_l1'>
		<ul>
			<?php echo ($user['is_login']===FALSE) ? '': '<li>'.anchor('account', "Hello, {$user['firstname']}").'</li>';?>
			<li><?php echo anchor($this->lang->switch_uri('en'), '<span class="">Eng</span>'); ?></li>
			<li><?php echo anchor($this->lang->switch_uri('zh'), '<span class="">繁</span>'); ?></li>
			<li><?php echo anchor($this->lang->switch_uri('cn'), '<span class="">簡</span>'); ?></li>
			<li><a href='http://www.facebook.com/pages/Casimira/326940370663389' target='_blank'><img class='fb_logo' src='/images/f_logo.png' /></a></li>
			<?php $item_count = count($cart)>0? "(".count($cart).")":''; ?>
			<li><?php echo anchor('cart', "<img class='fb_logo' src='/images/cart.png' /><span class='item_count'>$item_count</span>") ?></li>
			<li><?php echo ($user['is_login']===FALSE) ? anchor('login', T_('Login')) : anchor('logout', T_('Logout')) ?></li>
		</ul>
	</div>
	<div><?php echo anchor( base_url() . $this->lang->lang(), img( array('src' => 'logo.png', 'class' => 'logo') ) ) ?></div>
	<div class='menu_l2'>
		<ul>
			<li><?php echo anchor('company', T_('About us')); ?> / </li>			
			<li><?php echo anchor('browse/ladies/sales', T_('Ladies')); ?> / </li>
			<li><?php echo anchor('browse/men/sales', T_('Men')); ?> / </li>
			<li><?php echo anchor('', T_('Accessories')); ?> / </li>
			<li><?php echo anchor('news', T_('News')); ?> / </li>
			<li><?php echo anchor('info#location', T_('Location')); ?> / </li>
			<li><?php echo anchor('product_care', T_('Product Care')); ?> / </li>
			<li><?php echo anchor('info#contact', T_('Contact us')); ?></li>
		</ul>
	</div>
</div>
<div id="content">
	<div class="container">
