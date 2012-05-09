<?php echo css('css/products.css'); ?>
<?php echo css('css/cart.css') ?>
<?php
function get_color_str($item, $lang){
	if( isset( $item['color_name'] ) ){
		return $item['color_name']['name_' . $lang];
	}
	return $item['color'];
}
?>
<div class='pad'>
	<script type='text/javascript'>
	$(function(){
		shop_cart.add_cart_url = '<?php echo $page['add_cart_url']?>';
		shop_cart.del_cart_url = '<?php echo $page['del_cart_url']?>';
		shop_cart.payment_url = '<?php echo $page['payment_url']?>';
		
		shop_cart.cur_item = new shop_cart.item;
		shop_cart.item_count = <?php echo count($cart)?>;
		$('a[class=del_item]').click(function(){ 
			shop_cart.del_item.call($(this));
			$(this).closest("tr[class=cart_item]").remove();
			setTotal();
		});
		
		setRemoveButton();
		setTotal();
	});

	function setRemoveButton(){
		var buttons = $('.btn-remove');
		buttons.attr('src', '/images/cross.png');
		buttons.attr('alt', '<?php echo T_('Remove this item from cart') ?>');
		buttons.attr('title', '<?php echo T_('Remove this item from cart') ?>');
	}

	function setTotal(){
		var total = 0;
		$.each( $('.subtotal'), function( key, obj){
			total += parseInt( $(obj).html() );
		});
		$('#total').html(total);
	}

	</script>

	<div id="product-list">	
		<table>
			<thead>
				<tr>
					<th></th>
					<th><?php echo T_("Product Code");?> </th>
					<th><?php echo T_("Color");?></th>
					<th><?php echo T_("Size");?></th>
					<th><?php echo T_("Unit Price");?></th>
					<th><?php echo T_("Discount");?></th>
					<th><?php echo T_("Quantity");?></th>
					<th><?php echo T_("Total");?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
			if ( ! empty($this->data['cart']) ){
				foreach($cart as $key=>$each_item){
					$color = get_color_str( $each_item, $page['lang'] );
					$total = $each_item['discount']*$each_item['quantity'];
					echo <<<CART_ITEM
						<tr class="cart_item">
							<td><img class="cart-thumbnail"src="{$each_item['filepath']}"/></td>
							<td>{$each_item['id']}</td>
							<td>{$color}</td>
							<td>{$each_item['size']}</td>
							<td>{$each_item['price']}</td>
							<td>{$each_item['discount']}</td>
							<td>{$each_item['quantity']}</td>
							<td><span class='subtotal'>$total</span></td>
							<td><a href='#' class='del_item' value='$key'><img class='btn-remove' /></a></td>
						</tr>
CART_ITEM;
				}
			}
			else{ ?>
				<tr><td colspan='8' style='text-align: center'><span class='no-item'><?php echo T_('You do not have any item in your cart') ?></span></td></tr>
			<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan='7'><span class='title'><?php echo T_('Total') ?></span></td>
					<td colspan='1'><span id='total'></span></td>
				</tr>
			</tfoot>
		</table>
		<?php if ( ! empty($this->data['cart']) ){ ?>
			<div id='checkout-panel'>
				<span class='checkout'><?php echo T_('Check out') ?>: </span>
				<input type='image' name='button' onclick ="checkout(0);" class='checkout-button' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' align='top' alt='Check out with PayPal'/>
				<input type='image' name='button' onclick ="checkout(1);" class='checkout-button' src='https://img.alipay.com/pa/img/home/logo-alipay-t.png' border='0' align='top' alt='Check out with PayPal'/></span>
			</div>
		<?php } ?>
		<input type="hidden" name="cl" value="<?php echo count($cart); ?>"/>
		<div class='clear'></div>
	</div>
</div>

<div class="modal" name="login_modal" style="display:none;"></div>
<script type='text/javascript' src="/js/jquery.json-2.3.min"></script>