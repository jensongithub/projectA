<html>
<head>
	<?php $this->load->helper(array('html')); ?>
	<title><?php echo $title ?> - Casimira</title>
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
			<li><a href='http://facebook.com/casimira'>Facebook</a></li>
			<li><a href='/login'>Login</a></li>
			<li><a href='/cart'>Shopping Cart</a></li>
			<li><a href='/contact'>Contact Us</a></li>
		</ul>
	</div>
	<div class='menu_l2'>
		<img class='logo' src='/images/logo.png' />
		<ul>
			<li><a href='/company'>The Company</a></li>
			<li><a href='/news'>News</a></li>
			<li><a href='/women'>Women</a></li>
			<li><a href='/men'>Men</a></li>
			<li><a href='/accessories'>Accessories</a></li>
			<li><a href='/sales'>Sales</a></li>
			<li><a href='/location'>Location</a></li>
			<li><a href='/sitemap'>Site Map</a></li>
		</ul>
	</div>
</div>
