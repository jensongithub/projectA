<script type='text/javascript'>
var pid = '<?php echo $id ?>';
var colors = <?php echo $colors_json ?>;
var path = '<?php echo "$path/" ?>';
var holder = pid + colors.c0.color;
</script>
<script type='text/javascript'>
	$(document).ready(function(){
		$('.product-color > img').click(function(){
			holder = pid + $(this).attr('alt');
			var prefix = path + holder;
			$('#product-name').html( holder );
			$('#img0').attr('src', prefix + '-F.JPG');
			$('#img1').attr('src', prefix + '-B.JPG');
			$('#img2').attr('src', prefix + '-D1.JPG');
			$('#img3').attr('src', prefix + '-D2.JPG');
			$('#showcase-stage').attr('src', prefix + '-F.JPG');
		});
		
		$('#size-chart-switch').attr('href', path + pid + "-size.jpg");
		
		$('#mask').click(function(){
			$(this).css('display', 'none');
		});
	});
	
	function loadSizeChart(){
		var mask = $('#mask');
		mask.css('top', 0);
		mask.css('left', 0);
		mask.css('display', 'block');
		$('#size-chart-holder').html( "<img src='" + path + pid + "-size.jpg' />" );
	}
</script>

<div id="content" class='container'>
	<div class="content">
		<div class="container">
			<div id='product-image'>
				<div id='showcase'>
					<?php
					$files = array();
					$files[] = "products/$cat/$id" . $colors[0]['color'] . "-F.JPG";
					$files[] = "products/$cat/$id" . $colors[0]['color'] . "-B.JPG";
					$files[] = "products/$cat/$id" . $colors[0]['color'] . "-D1.JPG";
					$files[] = "products/$cat/$id" . $colors[0]['color'] . "-D2.JPG";
					$list = array();
					
					$attr = array( 'id' => 'showcase-stage', 'src' => $files[0], 'class' => 'showcase-normal');
					echo img($attr);
					
					foreach( $files as $key => $file ){
						if( file_exists( "images/$file" ) )
							$list[] = img( array( 'id' => "img$key", 'src' => $file, 'class' => 'showcase-thumbnail') );
					}
					
					

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
							anchor(str_replace('&', '%26', 'dept/browse/' . $cat . '/'), _( ucfirst($cat) )),
							' > ',
							$id
				);

				$attr = array(
							'id' => 'product-path'
				);

				echo ul($list, $attr);
				?>
				<div class='clear'></div>

				<div id='product-name' class='product-name'><?php echo $id.$colors[0]['color']; ?></div>

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
						<ul>
							<?php
							foreach( $colors as $color ) {
								echo "<li class='product-color' title='${color['color']}' style='background-color: $color'>";
								echo img( array( 'src' => "products/$cat/".$id.$color['color'].'-F.JPG', 'class' => 'color-thumbnail', 'alt' => "${color['color']}") );
								echo "</li>";
							}
							?>
						</ul>						
					</div>
					<div class='clear'></div>

					<div>
						<h4>Size:</h4>
						<span id="selected-size"><a id='size-chart-switch' href='' target='_blank'>Size Chart</a></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
#mask {
	position: fixed;
	width: 100%;
	height: 100%;
	background-color: #333;
	opacity: 0.5;
}

#size-chart-holder {
	position: fixed;
	margin: auto auto auto auto;
	width: 500px;
	height: 400px;
}
</style>
<div id='mask'>
<div id='size-chart-holder'>
</div>
</div>