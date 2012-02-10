<html>
<head>
	<?php $this->load->helper(array('html')); ?>
	<title>Casimira - <?php echo $title ?></title>
	<?php echo css('style.css'); ?>
</head>
<body>
<?php $this->load->helper(array('html', 'language', 'url')); ?>

<div id='header'>
	<div id='lang-switcher'>
		<!--?php echo anchor($this->lang->switch_uri('en'), '<div class="lang-switch">Eng</div>'); ?-->
		<!--?php echo anchor($this->lang->switch_uri('zh'), '<div class="lang-switch">繁</div>'); ?-->
		<div class='clear'></div>
	</div>
	<div class='menu_l1'>
		<ul>
			<li><a href='http://facebook.com/casimira'>Facebook</a></li>
			<li><a href='login'>Login</a></li>
			<li><a href='cart'>Shopping Cart</a></li>
			<li><a href='contact'>Contact Us</a></li>
		</ul>
	</div>
	<div class='menu_l2'>
		<?php echo anchor( '/', img(array('src' => 'logo.png', 'class' => 'logo') ) ); ?>
		<ul>
			<li><?php echo anchor('company', 'The Company'); ?></li>
			<li><a href='news'>News</a></li>
			<li><?php echo anchor('women', 'Women'); ?></li>
			<li><?php echo anchor('men', 'Men'); ?></li>
			<li><a href='accessories'>Accessories</a></li>
			<li><a href='sales'>Sales</a></li>
			<li><a href='location'>Location</a></li>
			<li><a href='sitemap'>Site Map</a></li>
		</ul>
	</div>
</div>
