<div id="content" class='container'>
	<div class="content">
		<div id="cat-menu">
			<?php echo $layout['list']; ?>
		</div>
		
		<div class="container">
			<div class="category-head">
				<h3><?php echo $cat_item['name']; ?></h3>
				<span><?php if( isset($path) ) echo $path[0]; ?></span>
			</div>
			
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