<?php $this->load->helper('my_path'); ?>
<div class='menu_l1'>
	<ul>
		<li>Facebook</li>
		<li>My Account</li>
		<li>Login</li>
		<li>Shopping Cart</li>
		<li>Contact Us</li>
	</ul>
</div>
<div class='menu_l2'>
	<ul>
		<li>Logo</li>
		<li>The Company</li>
		<li>News</li>
		<li>Women</li>
		<li>Men</li>
		<li>Accessories</li>
		<li>Sales</li>
		<li>Location</li>
		<li>Site Map</li>
	</ul>
</div>

<?php $this->load->helper('html'); ?>

<div id="content" class='container'>
	<!--<div id="slider-container" class="container">
			<?php echo img( array(
					'src' => 'single.jpg',
					'alt' => 'The slider goes here',
					'title' => 'The slider goes here',
					'width' => '100%',
					'height' => '100%') ); ?>
	</div>-->
	<div id='slider-container'>
		<?php echo css('js/nivo-slider/themes/default/default.css', 'screen', FALSE); ?>
		<?php echo css('js/nivo-slider/nivo-slider.css', 'screen', FALSE); ?>
		<div class="slider-wrapper theme-default">
			<div class="ribbon"></div>
			<div id="slider" class="nivoSlider">
				<?php //echo img('slider/toystory.jpg'); ?>
				<?php //echo img('slider/up.jpg'); ?>
				<?php //echo img('slider/walle.jpg'); ?>
				<?php echo img('slider/nemo.jpg'); ?>
				<?php echo img('single.jpg'); ?>
			</div>
		</div>
		<script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<?php echo js('nivo-slider/jquery.nivo.slider.pack.js'); ?>
		<script type="text/javascript">
			$(window).load(function() {
				$('#slider').nivoSlider({
					effect: 'slideInLeft',
					directionNavHide: false,
					controlNav: false,
					pauseTime: 5000,
					animSpeed: 300
				});
			});
		</script>
	</div>

	<div class="container">
		<h1>Showcase</h1>
	</div>

	<div class="container">
		<div class="container-col-span-1">
			<?php echo img('1A_0106.jpg'); ?>
		</div>
		<div class="container-col-span-1">
			<?php echo img('1B_0106.jpg'); ?>
		</div>
		<div class="container-col-span-1">
			<?php echo img('1C_1_0106.jpg'); ?>
		</div>
		<div class="container-col-span-1-last">
			<?php echo img('1C_2_0106.jpg'); ?>
		</div>
		<div class="clear"></div>
	</div>

	<div class="container">
		<h2>Showcase</h2>
	</div>

	<div class="container">
		<div class="container-col-span-1">
			<?php echo img('3A_0106.jpg'); ?>
		</div>
		<div class="container-col-span-1">
			<div class="container-col-upper">
			<?php echo img('6D_1125.jpg'); ?>
			</div>
			<div class="container-col-lower">
			<?php echo img('zhaopin_0914.gif'); ?>
			</div>
		</div>
		<div class="container-col-span-1">
			<?php echo img('3B_1_0106.jpg'); ?>
		</div>
		<div class="container-col-span-1-last">
			<?php echo img('3C_1_0106.jpg'); ?>
		</div>
		<div class="clear"></div>
	</div>
</div>