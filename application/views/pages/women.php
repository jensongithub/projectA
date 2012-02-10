<div id="content" class='container'>
	<div class="content">
		<div id="cat-menu">
			<div class=''>
				<h4><?php echo lang('women'); ?></h4>
				<p><a href=''>SALES</a></p>
				<p><a href=''>TOPS</a></p>
				<p><a href=''>Tees & Knit</a></p>
				<p><a href=''>Dress</a></p>
				<p><a href=''>Cashmere</a></p>
				<div class=''>
					<p><?php echo anchor('pages/women/sweaters', 'Sweaters'); ?></p>
					<div class='category-level'>
						<p><?php echo anchor('pages/women/cardigans', 'Cardigans'); ?></p>
						<p><a href=''>Vests</a></p>
						<p><a href=''>Crewnecks & V-necks</a></p>
						<p><a href=''>Shawl Collars & Henlexs</a></p>
						<p><a href=''>Turlenecks</a></p>
						<p><a href=''>Cables</a></p>
					</div>
				</div>
				<p><a href=''>Trousers</a></p>
				<p><a href=''>Denmin Trousers</a></p>
				<p><a href=''>Inner Wear</a></p>
			</div>
		</div>

		<div id='cat-main' class="container">
			<div class="category-head">
				<h3><?php echo $cat; ?></h3>
				<span><?php if( isset($path) ) echo $path[0]; ?></span>
			</div>
			<?php
				foreach( $products as $item ) {
			?>
			<div class="product-thumbnail">
				<a><?php echo img("web-11-11-2011/WOMEN/$item"); ?></a>
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