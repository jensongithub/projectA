<?php $this->load->helper('my_html'); ?>

<div id="content" class='container'>
	<div id="slider-container" class="container">
			<?php echo img( array(
					'src' => 'single.jpg', 
					'alt' => 'The slider goes here', 
					'title' => 'The slider goes here', 
					'width' => '100%', 
					'height' => '100%') ); ?>
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