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
					$level = count( explode('.', $item['level']) ) - 1;
					if( $level == 1 )
						echo "<div class='menu-item level-$level'>+ " . anchor('dept/women/' . $item['id'], $item['text']) . "</div>";
					else if( $level > 1 )
						echo "<div class='menu-item level-$level'>" . anchor('dept/women/' . $item['id'], $item['text']) . "</div>";
				}
				?>
			</div>
		</div>

		<div id='cat-main' class="container">
			<div class="category-head">
				<h3><?php echo ucfirst($cat); ?></h3>
			</div>
			<?php
				$path = $category['path'];
				foreach( $products as $item ) {
			?>
			<div class="product-thumbnail">
				<?php
				echo "/images/products/$path/${item['id']}-F.JPG";
				if( file_exists( "/images/products/$path/${item['id']}-F.JPG" ) ){
					echo anchor("dept/WOMEN/${cat['id']}/view/" . $item_name[0], img("products/${cat['name']}/${item['cat']}/${item['name']}-F.JPG"));
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