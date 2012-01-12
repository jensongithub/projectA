<?php $this->load->helper('my_path'); ?>

<div id="content" class='container'>
	<div class="content">
		<div id="cat-menu">
			<?php echo $layout['list']; ?>		
		</div>
		
		<div class="container">
			<?php
				for( $i = 0; $i < 16; $i++ ) {
			?>
			<div class="product-thumbnail">
				<a><img /></a>
				<span>Product name</span><br />
				<span>$Price</span><br />
				<span>Color</span>
			</div>
			<?php
				}
			?>
		</div>
	</div>
</div>