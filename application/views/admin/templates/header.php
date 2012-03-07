<html>
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
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
			<li><a href='http://facebook.com/casimira'><img class='fb_logo' src='/images/f_logo.png' /></a></li>
			<li><a href='cart'><img class='fb_logo' src='/images/cart.png' /></a></li>
			<li><?php echo anchor('login', _('Login')); ?></li>
		</ul>
	</div>
	<div class='menu_l2'>
		<?php echo anchor( '/', img(array('src' => 'logo.png', 'class' => 'logo') ) ); ?>
		<ul>
			<li><?php echo anchor('admin/', _('Dashboard')); ?></li>
			<li><?php echo anchor('admin/edit_categories', _('Categories & Menu')); ?></li>
			<li><?php echo anchor('admin/edit_products', _('Products')); ?></li>
			<li><?php echo anchor('admin/', _('Location')); ?></li>
			<li><?php echo anchor('admin/', _('Contact us')); ?></li>
		</ul>
	</div>
</div>

<div id='content' class='container'>
	<div class='content'>