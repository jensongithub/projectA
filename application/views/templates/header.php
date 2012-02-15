<html>
<head>
	<title><?php echo sprintf("Casimira - %s", _($title)); ?></title>
	<?php echo css('style.css'); ?>
</head>
<body>

<div id='header'>
	<div class='menu_lang'>
		<ul>

		</ul>
	</div>
	<div class='menu_l1'>
		<ul>
			<li><?php echo anchor($this->lang->switch_uri('en'), '<span class="">Eng</span>'); ?></li>
			<li><?php echo anchor($this->lang->switch_uri('zh'), '<span class="">繁</span>'); ?></li>
			<li><a href='/cn'>簡</a></li>
			<li><a href='http://facebook.com/casimira'><img class='fb_logo' src='/images/f_logo.png' /></a></li>
			<li><a href='cart'><img class='fb_logo' src='/images/cart.png' /></a></li>
			<li><?php echo anchor('login', _('Login')); ?></li>
		</ul>
	</div>
	<div class='menu_l2'>
		<?php echo anchor( '/', img(array('src' => 'logo.png', 'class' => 'logo') ) ); ?>
		<ul>
			<li><?php echo anchor('company', _('The Company')); ?></li>
			<li><?php echo anchor('news', _('News')); ?></li>
			<li><?php echo anchor('dept/women', _('Women')); ?></li>
			<li><?php echo anchor('dept/men', _('Men')); ?></li>
			<li><?php echo anchor('dept/accessories', _('Accessories')); ?></li>
			<li><?php echo anchor('sales', _('Sales')); ?></li>
			<li><?php echo anchor('company#location', _('Location')); ?></li>
			<li><?php echo anchor('sitemap', _('Sitemap')); ?></li>
			<li><?php echo anchor('company#contact', _('Contact us')); ?></li>
		</ul>
	</div>
</div>
