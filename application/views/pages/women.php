<div id="content" class='container'>
	<div class="content">
	
		<script type='text/javascript'>
		</script>
			
		<div id="cat-menu">
			<div class=''>
				<h4><?php echo _('WOMEN'); ?></h4>
				<?php
				foreach( $menu as $item ){
					$item_name = explode('/', $item['name']);
					$level = count( explode('.', $item['level']) ) - 1;
					if( $level == 1 )
						echo "<div class='menu-item level-$level'>+ " . anchor('dept/browse/' . str_replace('&', '%26', $item['name']), $item['text']) . "</div>";
					else if( $level > 1 )
						echo "<div class='menu-item level-$level'>" . anchor('dept/browse/' . str_replace('&', '%26', $item['name']), $item['text']) . "</div>";
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
				if( isset($item['image']) && file_exists( "images/products/$path/${item['image']}" ) ){
			?>
			<div class="product-thumbnail">
				<?php
					echo anchor( str_replace('&', '%26', "dept/view/$cat/" . $item['id']), img("products/$path/${item['image']}"));
				?>
				<hr style='border-color: #501100; color: #501100; margin: 5px 10px' />
				<span><?php echo $item['id'] ?></span><br />
				<span>$<?php echo $item['price'] ?></span><br />
			</div>
			<?php
				}
			}
			?>
		</div>
	</div>
</div>