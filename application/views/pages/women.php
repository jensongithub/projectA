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
						echo "<div class='menu-item level-$level'>+ " . anchor('browse/' . str_replace('&', '%26', $item['name']), $item['text']) . "</div>";
					else if( $level > 1 )
						echo "<div class='menu-item level-$level'>" . anchor('browse/' . str_replace('&', '%26', $item['name']), $item['text']) . "</div>";
				}
				?>
			</div>
		</div>

		<div id='cat-main' class="container">
			<div class="category-head">
				<h3>
				<?php 
				foreach($path as $item){
					echo anchor( 'browse/' . $item['c_path'], $item['text'] ) . ' / ';
				}
				?>
				</h3>
			</div>
			<?php
			foreach( $products as $item ) {
				if( isset($item['image']) && file_exists( "images/products/${item['i_path']}/${item['image']}" ) ){
			?>
			<div class="product-thumbnail">
				<?php
					echo anchor( str_replace('&', '%26', "view/${item['c_path']}/" . $item['id']), img("products/${item['i_path']}/${item['image']}"));
				?>
				<hr style='border-color: #501100; color: #501100; margin: 5px 10px' />
				<span><?php echo anchor( str_replace('&', '%26', "view/$cat/" . $item['id']), $item['id'] ) ?></span><br />
				<span>$<?php echo $item['price'] ?></span><br />
			</div>
			<?php
				}
			}
			?>
		</div>
	</div>
</div>