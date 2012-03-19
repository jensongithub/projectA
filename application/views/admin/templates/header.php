<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<title><?php echo sprintf("Casimira - %s", _($title)); ?></title>
	<?php echo css('style.css'); ?>
	<script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
</head>
<body>
<div id='header'>
	<div class='menu_lang'>
		<ul>
			
		</ul>
	</div>
	<div class='menu_l1'>
		<ul>

			<?php echo ($this->common_model->is_login()===FALSE) ? '': '<li>Hello, '.$firstname. '</li>';?>
			<li><?php echo anchor($this->lang->switch_uri('en'), '<span class="">Eng</span>'); ?></li>
			<li><?php echo anchor($this->lang->switch_uri('zh'), '<span class="">繁</span>'); ?></li>
			<li><?php echo anchor($this->lang->switch_uri('cn'), '<span class="">簡</span>'); ?></li>
			<li><a href='http://www.facebook.com/pages/Casimira/326940370663389'><img class='fb_logo' src='/images/f_logo.png' /></a></li>
			<li><a href='cart'><img class='fb_logo' src='/images/cart.png' /></a></li>
			<li><?php echo ($this->common_model->is_login()===FALSE) ? anchor('login', _('Login')) : anchor('logout', _('Logout')) ?>
		</ul>
	</div>
	<div class='menu_l2'>
		<?php echo anchor( '/', img(array('src' => 'logo.png', 'class' => 'logo') ) ); ?>
		<ul>
			<li><?php echo anchor('admin/', _('Dashboard')); ?></li>
			<li><?php echo anchor('admin/edit_categories', _('Categories')); ?></li>
			<li><?php echo anchor('admin/edit_menu', _('Menu')); ?></li>
			<li><?php echo anchor('dept/accessories', _('Accessories')); ?></li>
			
		</ul>
		<ul>
			<li><?php echo anchor('sales', _('Sales')); ?></li>
			<li><?php echo anchor('admin/edit_content/company', _('About us')); ?></li>
			<li><?php echo anchor('admin/edit_content/news', _('News')); ?></li>			
			<li><?php echo anchor('admin/edit_products', _('Products')); ?></li>
			<li><?php echo anchor('admin/edit_content/info', _('Location')); ?></li>
		</ul>

		
	</div>
</div>

<div id="content" class='container'>
	<div class='content'>
