<script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<div id="content" class='container'>
	<div class="content">
		<div class="container">
			<div id='product-image'>
				<div id='showcase'>
					<?php
					$attr = array( 'id' => 'showcase-stage', 'src' => "web-11-11-2011/WOMEN/$id", 'class' => 'showcase-normal');
					echo img($attr);

					$list = array(
								img( array( 'src' => "web-11-11-2011/WOMEN/$id", 'class' => 'showcase-thumbnail') ),
								img( array( 'src' => 'web-11-11-2011/WOMEN/IMG_2525a.jpg', 'class' => 'showcase-thumbnail') ),
								img( array( 'src' => 'web-11-11-2011/WOMEN/IMG_2559a.jpg', 'class' => 'showcase-thumbnail') ),
								img( array( 'src' => 'web-11-11-2011/WOMEN/DSL421-5a.jpg', 'class' => 'showcase-thumbnail') )
					);

					$attr = array(
										'id' => 'showcase-backstage'
					);

					echo ul($list, $attr);
					?>
					<script type='text/javascript'>
						$('.showcase-thumbnail').click(function(){
							$('#showcase-stage').attr('src', $(this).attr('src'));
						});
					</script>
				</div>
				<div id='similar-products'>
					<h3><?php echo _('Similar Products'); ?></h3>
					<ul>
						<?php foreach( array('IMG_2533a.jpg', 'IMG_2543a.jpg', 'DSL424-1a.jpg', 'DSL424-3a.jpg') as $product) { ?>
						<li class="similar-thumbnail">
							<?php echo anchor("dept/women/$cat/view/$product", img("web-11-11-2011/WOMEN/$product") ); ?>
							<span>Product name</span><br />
							<span>$Price</span><br />
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>

			<div id='product-text'>
				<?php
				$list = array(
							anchor('dept/' . $dept, _( ucfirst($dept) )),
							' > ',
							anchor('dept/' . $dept . '/' . $cat, _( ucfirst($cat) )),
							' > ',
							$id
				);

				$attr = array(
									'id'    => 'product-path'
				);

				echo ul($list, $attr);
				?>
				<div class='clear'></div>

				<div class='product-name'><?php echo $id; ?></div>

				<div id='product-description'>
					<div style='margin-bottom: 30px;'>
						<h4><?php echo _('Description'); ?></h4>
						<p>Short, loose-fitting purl-knit jumper in marled textured yarn with 3/4-length sleeves. </p>
					</div>

					<div>
						<h4><?php echo _('Details'); ?></h4>
						<p>69% acrylic, 18% polyamide, 13% cotton. Machine wash at 40˚ </p>
					</div>
					<div style='margin-top:1em;'><label>Quantity</label> <input style='width:3em;' type='text' name='qty'/>Pieces</div>
					<span><a href='#'>Buy</a></span><span style='margin-left:2em;'><a href='#'>Add to Basket</a></span>
				</div>

				<div id='product-options'>
					<div style='margin-bottom: 30px;'>
						<h4>Colour:</h4>
						<span id="selected-color">Beige</span>
						<ul>
							<?php
							foreach( array('Beige', 'Black', 'DarkBlue', 'Red') as $color ) {
								echo "<li class='product-color' title='$color' style='background-color: $color'></li>";
							}
							?>
						</ul>
						<script type='text/javascript'>
							$('.product-color').click(function(){
								$('#selected-color').html($(this).attr('title'));
								$('.product-color').removeClass('selected');
								$(this).addClass('selected');
							});
						</script>
					</div>

					<div>
						<h4>Size:</h4>
						<span id="selected-size">34 - 46 <a href='#'>Size Chart</a></span>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>