<div id="content" class='container'>
	<div class="content">
	
		<script type='text/javascript'>
		</script>
			
		<div id="cat-menu">
			<div class=''>
				<h4><?php if( isset($page['path'][0]) ) echo $page['path'][0]['text_' . $page['lang']]; ?></h4>
				<?php
				if( isset($page['menu']) )
					foreach( $page['menu'] as $item ){
						$level = count( explode('.', $item['level']) ) - 1;
						if( $level == 1 )
							echo "<div class='menu-item level-$level'>+ " . anchor('browse/' . str_replace('&', '%26', $item['c_path']), $item['text_' . $page['lang']]) . "</div>";
						else if( $level > 1 )
							echo "<div class='menu-item level-$level'>" . anchor('browse/' . str_replace('&', '%26', $item['c_path']), $item['text_' . $page['lang']]) . "</div>";
					}
				?>
			</div>
		</div>

		<div id='cat-main' class="container">
		<?php if( isset( $page['error'] ) ){ ?>
			<div class='error-panel'>
				<?php echo $page['error']; ?>
			</div>
			<?php } ?>
			<div class="category-head">
				<h3>
				<?php 
				foreach($page['path'] as $item){
					echo anchor( 'browse/' . $item['c_path'], $item['text_' . $page['lang']] ) . ' / ';
				}
				?>
				</h3>
				<div class='page-nav'>
					<?php
					if( isset($page['prev']) ) echo anchor($page['url'] . $page['prev'], "<div class='prev-page'>&lt; " . _('Previous page') . "</div>");
					if( isset($page['next']) ) echo anchor($page['url'] . $page['next'], "<div class='next-page'>" . _('Next page') . " &gt;</div>");
					?>
				</div>
			</div>
			
			<div>
				<?php
				if( isset( $page['cat_showcase'] ) && $page['cat_showcase'] ){
					$attr = array( 'src' => $page['cat_showcase'], 'class' => 'cat-showcase' );
					echo img($attr);
				}
				?>
				<?php
				if( isset($page['products']) )
					foreach( $page['products'] as $item ) {
						//if( isset($item['front_img']) && file_exists( "images/products/${item['i_path']}/${item['front_img']}" ) ){
				?>
				<div class="product-thumbnail">
					<?php
						echo anchor( str_replace('&', '%26', "view/${item['c_path']}/" . $item['id']), img( array( 'src' => "products/${item['i_path']}/${item['front_img']}", 'class' => 'thumbnail-img') ));
					?>
					<!--<hr style='border-color: #501100; color: #501100; margin: 5px 10px' />-->
					<span><?php echo anchor( str_replace('&', '%26', "view/${item['c_path']}/" . $item['id']), $item['id'] ) ?></span><br />
					<?php if( $item['discount'] < $item['price'] ) { ?>
						<span style='text-decoration: line-through;'> $<?php echo $item['price'] ?> </span><br />
						<span class='discount-tag'>$<?php echo $item['discount'] ?></span><br />
					<?php } else { ?>
						<span>$<?php echo $item['price'] ?></span><br />
					<?php } ?>
				</div>
				<?php
					//}
				}
				?>
			</div>
			<div class='clear'></div>
			
			<div class='page-nav'>
				<?php
				if( isset($page['prev']) ) echo anchor($page['url'] . $page['prev'], "<div class='prev-page'>&lt; " . _('Previous page') . "</div>");
				if( isset($page['next']) ) echo anchor($page['url'] . $page['next'], "<div class='next-page'>" . _('Next page') . " &gt;</div>");
				?>
			</div>
		</div>
	</div>
</div>