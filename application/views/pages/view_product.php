<?php echo css('css/products.css') ?>
<script type='text/javascript'>
var pid = '<?php echo $page['id'] ?>';
var colors = <?php echo $page['colors_json'] ?>;
var path = '<?php echo $page['path']."/" ?>';
var holder = pid + colors.c0.color;
var measurementHolder = false;
var chartHolder = false;

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
var zoomRatio = { width: 1, height: 1 };
if( new String(navigator.appVersion).indexOf('Chrome') >= 0 ){
	zoomRatio.width = 1;
	zoomRatio.height = 1;
}
</script>
<script type='text/javascript'>
function CreateDelegate(contextObject, delegateMethod){
	return function() {
		return delegateMethod.apply(contextObject, arguments);
	}
}

function imgTesting_onload() {
	var zoomIndicator = $('.zoom-area');
	var zoomInImg = $('.zoom-in');
	imgSize.width = this.width * zoomRatio.width;
	imgSize.height = this.height * zoomRatio.height;
	zoomInImg.css('width', imgSize.width);
	zoomInImg.css('height', imgSize.height);
	wRatio = imgSize.width / showcaseSize.width;
	hRatio = imgSize.height / showcaseSize.height;
	zoomAreaSize.width = zoomPanelSize.width / wRatio;
	zoomAreaSize.height = zoomPanelSize.height / hRatio;
	zoomIndicator.css('width', zoomAreaSize.width);
	zoomIndicator.css('height', zoomAreaSize.height);
	boundX = ( -imgSize.width + zoomPanelSize.width );
	boundY = ( -imgSize.height + zoomPanelSize.height );
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
		$('.product-name').html( holder );
		$('#img0').attr('src', prefix + '-F_s.jpg');
		$('#img1').attr('src', prefix + '-B_s.jpg');
		$('#img2').attr('src', prefix + '-D1_s.jpg');
		$('#img3').attr('src', prefix + '-D2_s.jpg');
		$('#showcase-img').attr('src', prefix + '-F.jpg');
	});

	initZoom();
	//initMagnifier();
	initSizeChart();
	initThumbnailEvent();
	initCartOperations();
	
	//$('.color-thumbnail:first').click();
});

function initSizeChart(){
	var canvas = $('.canvas');
	$('.mask').click(function(){
		$(this).css('display', 'none');
		canvas.css('display', 'none');
		$(document).unbind('keyup.esc');
	});

	$('#size-chart-switch').click(function(){
		$(document).bind('keyup.esc', function(e){
			if( e.keyCode == 27 ){
				$('.mask').css('display', 'none');
				canvas.css('display', 'none');
				$(document).unbind('keyup.esc');
			}
		});
	});
}

function showSizeChart(){
	//$('#size-chart-switch').attr('href', path + pid + "-size.jpg");
	var canvas = $('.canvas');

	if( ! measurementHolder ){
		measurementHolder = '<?php echo img( array( 'id' => 'measurement-holder', 'src' => 'products/size info-' . $page['lang'] . '.jpg' ) ) ?>';
		canvas.append(measurementHolder);
		var cWidth = $('#measurement-holder').width();
		canvas.css( 'width', cWidth );
		canvas.css( 'left', ($(window).width() - cWidth)/2 );
	}
	
	if( ! chartHolder ){
		chartHolder = '<?php echo img( array( 'id' => 'chart-holder', 'src' => "products/" . $page['i_path'] . "/" .  $page['id'] . '-size.jpg' ) ) ?>';
		canvas.append(chartHolder);
	}
	
	$('.mask').css('display', 'block');
	$('.canvas').css('display', 'block');
}

function initZoom() {
	var p = $('.zoom-panel'); // zoom panel
	var z = $('.zoom-in'); // actual zoom in image
	var a = $('.zoom-area'); // zoom area
	var s = $('#showcase-img'); // showcase image
	
	p.css('width', zoomPanelSize.width);
	p.css('height', zoomPanelSize.height);
	pos = getPosition(document.getElementById('showcase-img'));
	p.css('left', (360 + pos.left) + 'px');
	p.css('top', pos.top + 'px');
	//alert('top: ' + p.css('top') + '\nleft: ' + p.css('left'));
	
	z.attr('src', s.attr('src'));
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
		//$('#i1').val(aX);
		//$('#i2').val(aY);

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
		
		z.css('left', newX);
		z.css('top', newY);
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

function initCartOperations(){	
	shop_cart.item_count = <?php echo count($cart)?>;
	shop_cart.cur_item = new shop_cart.item;
	shop_cart.add_cart_url = '<?php echo $page['add_cart_url']?>';
	shop_cart.del_cart_url = '<?php echo $page['del_cart_url']?>';
	shop_cart.payment_url = '<?php echo $page['payment_url']?>';
	
	$('a[class=item_size]').click(
		function(){
		if (shop_cart.cur_item.size==$(this).attr('value')){
			$(".item_size").removeClass('selected-color');
			shop_cart.cur_item.size="";
		}else{
			$(".item_size").removeClass('selected-color');
			$(this).addClass('selected-color');
			shop_cart.cur_item.size=$(this).attr('value');
		}
	});
	
	$('a[class=item_color]').click(
		function(){
			if (shop_cart.cur_item.color==$(this).attr('value')){
				$(".product-color").removeClass('selected-color');
				shop_cart.cur_item.filepath = "";
				shop_cart.cur_item.color="";
			}else{
				$(".product-color").removeClass('selected-color');
				$(this).parent().addClass('selected-color');
				shop_cart.cur_item.color=$(this).attr('value');
				shop_cart.cur_item.filepath = $(this).children("img").attr("src");
			}
	});

	$('input[class=item_quantity]').change(function(){
		shop_cart.cur_item.quantity=$(this).attr('value');
	});
	
	$('a[class=add_item]').click(function(){
		shop_cart.add_item.call($(this));
	});
}

function buy_now(pg){
	var row=0;
		
	$('a[class=add_item]').click();
	
	if (shop_cart.add_rows!=0){
		shop_cart.pg=pg;
		shop_cart.payment_gateway();
	}
}

function reset_entry(){
	$('input[class=item_quantity]').val("");
	$('.item_color').removeClass('selected-size');
	$('.item_size').removeClass('selected-size');
	shop_cart.cur_item.color=""
	shop_cart.cur_item.size="";
	shop_cart.cur_item.quantity="";
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

<div class="content">
	<div id='product-image'>
		<div id='showcase'>
			<?php
			$files = array();
			$files[] = "products/{$page['i_path']}/{$page['id']}" . $page['colors'][0]['color'] . "-F_s.jpg";
			$files[] = "products/{$page['i_path']}/{$page['id']}" . $page['colors'][0]['color'] . "-B_s.jpg";
			$files[] = "products/{$page['i_path']}/{$page['id']}" . $page['colors'][0]['color'] . "-D1_s.jpg";
			$files[] = "products/{$page['i_path']}/{$page['id']}" . $page['colors'][0]['color'] . "-D2_s.jpg";
			$list = array();
			
			$attr = array( 'id' => 'showcase-img', 'src' => "products/{$page['i_path']}/{$page['id']}" . $page['colors'][0]['color'] . "-F.jpg", 'class' => 'showcase-normal');
			
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
			<h3><?php echo T_('Similar Products'); ?></h3>
			<ul>
				<?php foreach( $page['sim_pro']as $prod) { ?>
				<li class="similar-thumbnail">
					<?php echo anchor(str_replace('&', '%26', "view/" . $page['category']['c_path'] . "/" . $prod['id']), img("products/" . $page['category']['path'] . "/" . $prod['front_img'] ) ); ?>
					<span><?php echo anchor( str_replace('&', '%26', "view/" . $page['category']['c_path'] . "/" . $prod['id']), $prod['id'] ) ?></span><br />
					<?php if( $prod['discount'] < $prod['price'] ) { ?>
						<span style='text-decoration: line-through;'> $<?php echo $prod['price'] ?> </span><br />
						<span style='color: #F00'>$<?php echo $prod['discount'] ?></span><br />
					<?php } else { ?>
						<span>$<?php echo $prod['price'] ?></span><br />
					<?php } ?>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>

	<div id='product-text'>
		<?php
		$list = array();
		foreach( $page['c_path'] as $key => $item ){
			if( $key == 0 )
				$list[] = anchor( str_replace('&', '%26', 'browse/' . $item['c_path']) . '/sales', $item['text_' . $page['lang']] );
			else
				$list[] = anchor( str_replace('&', '%26', 'browse/' . $item['c_path']), $item['text_' . $page['lang']] );
			$list[] = ' > ';
		}
		$list[] = $page['id'];

		$attr = array(
					'id' => 'product-path'
		);

		echo ul($list, $attr);
		?>
		<div class='clear'></div>

		<div class='product-title'>
			<span class='product-name'><?php echo $page['id'] . $page['colors'][0]['color']; ?></span>
			<?php if( $page['product']['discount'] < $page['product']['price'] ) { ?>
				<span class='product-discount'> $<?php echo $page['product']['discount'] ?> </span>
				<span class='product-price'> $<?php echo $page['product']['price'] ?> </span>
			<?php } else { ?>
				<span class='product-discount'> $<?php echo $page['product']['price'] ?> </span>
			<?php } ?>
		</div>

		<div id='_product-description'>
			<div style='margin-bottom: 30px;'>
				<h4><?php echo T_('Description'); ?></h4>
				<p><?php echo $page['product']['description_' . $page['lang']] ?></p>
			</div>

			<div>
				<h4><?php echo T_('Details'); ?></h4>
				<div>
				<?php
				if( $page['product']['comp_list'] )
					foreach( $page['product']['comp_list'] as $comp ){
						echo "<p>" . $comp['percentage'] . " % " . $comp['name_' . $page['lang']] . "</p>";
					}
				?>
				</div>
			</div>


			<div style='margin-top:1em;'>
				<h4><?php echo T_('Colour') ?>:</h4>
				<ul>
					<?php
					foreach( $page['colors'] as $color ) {
						echo "<li class='product-color' title='${color['color']}'>";
						echo "<a href='javascript:void(0)' class='item_color' value='{$color['color']}'>".img( array( 'src' => "products/{$page['i_path']}/".$page['id'].$color['color'].'-F_s.jpg', 'class' => 'color-thumbnail', 'alt' => "${color['color']}", 'title' => isset($color['name_' . $page['lang']])?$color['name_' . $page['lang']]:$color['color'] ) )."</a>";
						echo "</li>";
					}
					?>
				</ul>
			</div>
			<div class='clear'></div>
			<div style='margin-top:1em;'>
				<h4><?php echo T_('Size') ?>: <a id='size-chart-switch' href='javascript: showSizeChart()'>Size Chart</a></h4>
				<a href='javascript:void(0);' class='item_size' value='S'>S</a>
				<a href='javascript:void(0);' class='item_size' value='M'>M</a>
				<a href='javascript:void(0);' class='item_size' value='L'>L</a>
				<a href='javascript:void(0);' class='item_size' value='XL'>XL</a>
				<div class='clear'></div>
			</div>
			
			<div style='margin-top:1em;'>
				<h4><?php echo T_('Quantity') ?>:<input style='width:3em;' class='item_quantity' type='text' value='' name='qty'/></h4>						
			</div>
			
			<div style='margin-top:1em;' class="payment_gateway">
				<span>
					<input type='image' name='button' onclick ="buy_now(0);" src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' align='top' alt='Check out with PayPal'/>
					<input type='image' name='button' onclick ="buy_now(1);" src='https://img.alipay.com/pa/img/home/logo-alipay-t.png' border='0' align='top' alt='Check out with PayPal'/></span>
					<span style='margin-left:2em;'><a href='javascript:void(0)' class='add_item' value='<?php echo $page['product']['id'] ?>'>Add to Cart</a>
					<?php echo $page['alipay_form']; ?>
					<input type="hidden" name="pg" value=""/>
					<input type="hidden" name="cl" value="<?php echo count($cart); ?>"/>
				</span>
			</div>
		</div>				
	</div>
</div>


<div class='mask'></div>
<div class='canvas'></div>
<script type='text/javascript' src="/js/jquery.json-2.3.min"></script>
<div class="modal" name="modal" style="display:none;"></div>