<div id="content" class='container'>
	<div id='slider-container'>
		<?php echo css('js/nivo-slider/themes/default/default.css', 'screen', FALSE); ?>
		<?php echo css('js/nivo-slider/nivo-slider.css', 'screen', FALSE); ?>
		<div class="slider-wrapper theme-default">
			<div class="ribbon"></div>
			<div id="slider" class="nivoSlider">
				<?php echo img('main-1-01.jpg'); ?>
				<?php echo img('main-2-01.jpg'); ?>
				<?php echo img('main-3-01.jpg'); ?>
				<?php echo img('main-4-01.jpg'); ?>
			</div>
		</div>
		<script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<?php echo js('nivo-slider/jquery.nivo.slider.pack.js'); ?>
		<script type="text/javascript">
			$(window).load(function() {
				$('#slider').nivoSlider({
					effect: 'fade',
					directionNavHide: false,
					controlNav: false,
					pauseTime: 5000,
					animSpeed: 300
				});
			});
		</script>
	</div>
</div>
