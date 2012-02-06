<html>
<head>
	<?php $this->load->helper(array('my_html')); ?>
	<title><?php echo $title ?> - CodeIgniter 2 Tutorial</title>
	<?php echo css('style.css'); ?>
</head>
<body>
<?php $this->load->helper(array('html', 'language', 'url')); ?>

<div id='header'>
	<div id='lang-switcher'>
		<?php echo anchor($this->lang->switch_uri('en'), '<div class="lang-switch">Eng</div>'); ?>
		<?php echo anchor($this->lang->switch_uri('zh'), '<div class="lang-switch">繁</div>'); ?>
		<div class='clear'></div>
	</div>
	<div class='menu_l1'>
		<ul>
			<li><a href=''>Facebook</a></li>
			<li><a href=''>My Account</a></li>
			<li><a href=''>Login</a></li>
			<li><a href=''>Shopping Cart</a></li>
			<li><a href=''>Contact Us</a></li>
		</ul>
	</div>
	<div class='menu_l2'>
		<ul>
			<li><a href=''>Logo</a></li>
			<li><a href=''>The Company</a></li>
			<li><a href=''>News</a></li>
			<li><a href=''>Women</a></li>
			<li><a href=''>Men</a></li>
			<li><a href=''>Accessories</a></li>
			<li><a href=''>Sales</a></li>
			<li><a href=''>Location</a></li>
			<li><a href=''>Site Map</a></li>
		</ul>
	</div>
</div>