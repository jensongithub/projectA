<div id="content" class='container'>
	<div class="content">
	
		<script type='text/javascript'>
		</script>
			
		<div id="cat-menu">
			<div class=''>
				<h4><?php echo _('WOMEN'); ?></h4>
				<?php
				foreach( $menu as $item ){
					$item_name = explode(' -> ', $item['name']);
					echo "<div>" . anchor('dept/women/' . $item['id'], $item['text']) . "</div>";
				}
				?>
			</div>
		</div>

		<div id='cat-main' class="container">
			<div class="category-head">
				<h3><?php echo ucfirst($cat['name']); ?></h3>
				<span><?php if( isset($path) ) echo $path[0]; ?></span>
			</div>
			<?php
				foreach( $products as $item ) {
					$item_name = explode('.', $item['name']);
			?>
			<div class="product-thumbnail">
				<?php
				if( isset($item['cat']) ) {
					if( file_exists( "images/products/${cat['name']}/${item['cat']}/${item['name']}-F.JPG" ) )
						echo anchor("dept/WOMEN/${cat['id']}/view/" . $item_name[0], img("products/${cat['name']}/${item['cat']}/${item['name']}-F.JPG"));
				}
				else{
					if( file_exists( "images/products/${cat['name']}/${item['name']}-F.JPG" ) )
						echo anchor("dept/WOMEN/${cat['id']}/view/" . $item_name[0], img("products/${cat['name']}/${item['name']}-F.JPG"));
				}
				?>
				<span><?php echo $item['name'] ?></span><br />
				<span>$Price</span><br />
			</div>
			<?php
				}
			?>
		</div>
	</div>
</div>