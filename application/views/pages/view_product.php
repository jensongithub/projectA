<script type='text/javascript'>
var pid = '<?php echo $id ?>';
var colors = <?php echo $colors_json ?>;
var path = '<?php echo "$path/" ?>';
var holder = pid + colors.c0.color;

var imgTesting;
var showcaseSize = { width: 350, height: 470 };
var pos;
var zoomPanelSize = { width: 550, height: 470 };
var zoomAreaSize = { width: 0, height: 0 };
var imgSize = { width: 0, height: 0 };
var wRatio, hRatio;
var boundX = ( -imgSize.width + zoomPanelSize.width );
var boundY = ( -imgSize.height + zoomPanelSize.height );
var offsetW = zoomPanelSize.width / 2;
var offsetH = (zoomPanelSize.height / 2);
</script>
<script type='text/javascript'>
function CreateDelegate(contextObject, delegateMethod){
	return function() {
		return delegateMethod.apply(contextObject, arguments);
	}
}

function imgTesting_onload() {
	imgSize.width = this.width;
	imgSize.height = this.height;
	wRatio = this.width / showcaseSize.width;
	hRatio = this.height / showcaseSize.height;
	zoomAreaSize.width = zoomPanelSize.width / wRatio;
	zoomAreaSize.height = zoomPanelSize.height / hRatio;
	$('.zoom-area').css('width', zoomAreaSize.width);
	$('.zoom-area').css('height', zoomAreaSize.height);
	boundX = ( -imgSize.width + zoomPanelSize.width );
	boundY = ( -imgSize.height + zoomPanelSize.height );
	offsetW = zoomPanelSize.width / 2;
	offsetH = (zoomPanelSize.height / 2);
}

function setZoomRatio(src){
	imgTesting = new Image();
	imgTesting.src = src;
	imgTesting.onload = CreateDelegate(imgTesting, imgTesting_onload);
}

$(document).ready(function($){
	$('.item_color > img').bind("click.change", function(){
		holder = pid + $(this).attr('alt');
		var prefix = path + holder;
		$('#product-name').html( holder );
		$('#img0').attr('src', prefix + '-F_s.jpg');
		$('#img1').attr('src', prefix + '-B_s.jpg');
		$('#img2').attr('src', prefix + '-D1_s.jpg');
		$('#img3').attr('src', prefix + '-D2_s.jpg');
		$('#showcase-img').attr('src', prefix + '-F.jpg');
	});
	
	$('#size-chart-switch').attr('href', path + pid + "-size.jpg");
	
	$('#mask').click(function(){
		$(this).css('display', 'none');
	});
	
	initZoom();
	//initMagnifier();
	initThumbnailEvent();
	initCartOperations();
});

function initZoom() {
	var p = $('.zoom-panel'); // zoom panel
	var z = $('.zoom-in'); // zoom image
	var a = $('.zoom-area'); // zoom area
	var s = $('#showcase-img'); // showcase image
	
	p.css('width', zoomPanelSize.width);
	p.css('height', zoomPanelSize.height);
	pos = getPosition(document.getElementById('showcase-img'));
	p.css('left', (360 + pos.left) + 'px');
	p.css('top', pos.top + 'px');
	//alert('top: ' + p.css('top') + '\nleft: ' + p.css('left'));
	
	z.attr('src', s.attr('src'));
	wRatio = s.width();
	setZoomRatio( s.attr('src') );
	$('#showcase-stage').mouseenter(function(){
		pos = getPosition(document.getElementById('showcase-img'));
		p.css('left', (360 + pos.left) + 'px');
		p.css('top', pos.top + 'px');
		p.css('display', 'block');
		a.css('display', 'block');
	});
	$('#showcase-stage').mouseleave(function(){
		p.css('display', 'none');
		a.css('display', 'none');
	});

	$('.showcase-thumbnail').bind('click.zoom', function(){
		z.attr('src', $(this).attr('src').replace("_s", ''));
		setZoomRatio(z.attr('src'));
	});
	
	$('#showcase-stage').mousemove(function(e){
		var newX = (e.pageX - pos.left) * -wRatio + offsetW;
		var newY = (e.pageY - pos.top) * -hRatio + offsetH;
		
		if( newX < boundX )
			newX = boundX;
		else if( newX > 0 )
			newX = 0;

		if( newY < boundY )
			newY = boundY;
		else if( newY > 0 )
			newY = 0;

		var aX = e.pageX - pos.left - zoomAreaSize.width/2;
		var aY = e.pageY - pos.top - zoomAreaSize.height/2;
		$('#i1').val(aX);
		$('#i2').val(aY);

		if( aX > ( showcaseSize.width - zoomAreaSize.width) )
			aX = showcaseSize.width - zoomAreaSize.width;
		else if( aX < 0 )
			aX = 0;

		if( aY > ( showcaseSize.height - zoomAreaSize.height) )
			aY = showcaseSize.height - zoomAreaSize.height;
		else if( aY < 0 )
			aY = 0;

		a.css('left', pos.left + aX);
		a.css('top', pos.top + aY);
		
		z.css('top', newY);
		z.css('left', newX);
	});
	
	$('.item_color > img').bind('click.zoom', function(){
		z.attr('src', $(this).attr('src').replace("_s", ''));
		setZoomRatio(z.attr('src'));
	});
}

function initThumbnailEvent(){
	$('.showcase-thumbnail').bind("click.change", function(){
		$('#showcase-img').attr('src', $(this).attr('src').replace("_s", '') );
	});
}

function initMagnifier(){
	var mag = $('#magnifier');
	var pos = getPosition(document.getElementById('showcase-img'));
	mag.css('left', pos.left + 'px');
	mag.css('top', pos.top + 'px');
	mag.css('display', 'inline');
	mag.click(function(){
		//$('#showcase-img').addimagezoom();
	});
}

function getPosition(obj){
	var topValue = 0, leftValue = 0;
	while (obj) {
		leftValue += obj.offsetLeft;
		topValue += obj.offsetTop;
		obj = obj.offsetParent;
	}
	return {
		left: leftValue,
		top: topValue
	};
}

function loadSizeChart(){
	var mask = $('#mask');
	mask.css('top', 0);
	mask.css('left', 0);
	mask.css('display', 'block');
	$('#size-chart-holder').html( "<img src='" + path + pid + "-size.jpg' />" );
}



function initCartOperations(){	
	shop_cart.cur_item = new shop_cart.item;
	$('a[class=item_size]').click(function(){
		shop_cart.cur_item.size=$(this).attr('value');
	});
	
	$('a[class=item_color]').click(function(){
		shop_cart.cur_item.color=$(this).attr('value');

	});		
	$('a[class=add_item]').click(function(){ shop_cart.add_item.call($(this));});		
}

function paypal_checkout(){ 
	$('a[class=add_item]').click();
	window.location.href='http://lna.localhost/checkout/paypal';
}
	
function alipay_checkout(){ 
	$('a[class=add_item]').click();
	window.location.href='http://lna.localhost/checkout/alipay';
}

</script>
<style type="text/css">
.magnifyarea{ /* CSS to add shadow to magnified image. Optional */
box-shadow: 5px 5px 7px #818181;
-webkit-box-shadow: 5px 5px 7px #818181;
-moz-box-shadow: 5px 5px 7px #818181;
filter: progid:DXImageTransform.Microsoft.dropShadow(color=#818181, offX=5, offY=5, positive=true);
background: white;
}
</style>

<div id="content" class='container'>
	<div class="content">
		<div class="container">
			<div id='product-image'>
				<div id='showcase'>
					<?php
					$files = array();
					$files[] = "products/$cat/$id" . $colors[0]['color'] . "-F_s.jpg";
					$files[] = "products/$cat/$id" . $colors[0]['color'] . "-B_s.jpg";
					$files[] = "products/$cat/$id" . $colors[0]['color'] . "-D1_s.jpg";
					$files[] = "products/$cat/$id" . $colors[0]['color'] . "-D2_s.jpg";
					$list = array();
					
					$attr = array( 'id' => 'showcase-img', 'src' => "products/$cat/$id" . $colors[0]['color'] . "-F.jpg", 'class' => 'showcase-normal');
					
					echo "<div id='showcase-stage'>" . img($attr) . "<div class='zoom-area'>" . img( array( 'id' => 'magnifier', 'src' => 'magnifier-left.png' ) ) . "</div></div>";

					foreach( $files as $key => $file ){
						if( file_exists( "images/$file" ) )
							$list[] = img( array( 'id' => "img$key", 'src' => $file, 'class' => 'showcase-thumbnail') );
					}
					
					$attr = array(
										'id' => 'showcase-backstage'
					);

					echo ul($list, $attr);
					?>
					<div class='zoom-panel'>
						<img class='zoom-in' />
					</div>
				</div>
				<div id='similar-products'>
					<h3><?php echo _('Similar Products'); ?></h3>
					<ul>
						<?php foreach( $sim_pro as $product) { ?>
						<li class="similar-thumbnail">
							<?php echo anchor(str_replace('&', '%26', "view/${category['c_path']}/${product['id']}"), img("products/${category['path']}/${product['id']}" . $product['color'] . "-F_s.jpg") ); ?>
							<span><?php echo $product['id'] ?></span><br />
							<span>$<?php echo $product['price'] ?></span><br />
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>

			<div id='product-text'>
				<?php
				$list = array(
				);
				foreach( $c_path as $item ){
					$list[] = anchor( str_replace('&', '%26', 'browse/' . $item['c_path']), _( ucfirst($item['text']) ) );
					$list[] = ' > ';
				}
				$list[] = $id;

				$attr = array(
							'id' => 'product-path'
				);

				echo ul($list, $attr);
				?>
				<div class='clear'></div>

				<div id='product-name' class='product-name'><?php echo $id.$colors[0]['color']; ?></div>

				<div id='_product-description'>
					<div style='margin-bottom: 30px;'>
						<h4><?php echo _('Description'); ?></h4>
						<p>Short, loose-fitting purl-knit jumper in marled textured yarn with 3/4-length sleeves. </p>
					</div>

					<div>
						<h4><?php echo _('Details'); ?></h4>
						<p>69% acrylic, 18% polyamide, 13% cotton. Machine wash at 40˚ </p>
					</div>
			
					<div style='margin-top:1em;'>
						<h4>Colour:</h4>
						<ul>
							<?php
							foreach( $colors as $color ) {
								echo "<li class='product-color' title='${color['color']}'>";
								echo "<a href='javascript:void(0)' class='item_color' value='${color['color']}'>".img( array( 'src' => "products/$cat/".$id.$color['color'].'-F_s.jpg', 'class' => 'color-thumbnail', 'alt' => "${color['color']}") )."</a>";
								echo "</li>";
							}
							?>
						</ul>
					</div>
					<div class='clear'></div>
					<div style='margin-top:1em;'>
						<h4>Size:<span id="selected-size"><a id='size-chart-switch' href='' target='_blank'>Size Chart</a></span><br/>
						</h4>
						<a href='javascript:void(0);' class='item_size' value='S'>S</a>
						<a href='javascript:void(0);' class='item_size' value='M'>M</a>
						<a href='javascript:void(0);' class='item_size' value='L'>L</a>
						<a href='javascript:void(0);' class='item_size' value='XL'>XL</a>
					</div>
					
					<div style='margin-top:1em;'>
						<h4>Quantity:<input style='width:3em;' class='item_quantity' type='text' value='' name='qty'/></h4>						
					</div>
					
					<div style='margin-top:1em;'>
						<span>
							<input type='image' name='button' onclick ='paypal_checkout();' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' align='top' alt='Check out with PayPal'/>
							<input type='image' name='button' onclick ='alipay_checkout();' src='https://img.alipay.com/pa/img/home/logo-alipay-t.png' border='0' align='top' alt='Check out with PayPal'/></span>
							<span style='margin-left:2em;'><a href='javascript:void(0)' class='add_item' value='<?php echo $product['id'] ?>'>Add to Cart</a>
						</span>
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
<div id='mask'><div id='size-chart-holder'></div></div>
<script type='text/javascript' src="/js/jquery.json-2.3.min"></script>
