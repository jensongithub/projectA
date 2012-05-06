<?php echo css('css/login.css'); ?>
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
	});
});
</script>

<div id="content" class='container'>
	<?php if (empty($this->data['cart'])){ ?>
		<div><?php echo _("No items"); ?></div>
	<?php }else{ ?>
	
		<table border=1>
			<thead>
				<tr>
					<th><?php echo _("Picture");?> </th>
					<th><?php echo _("Product Code");?> </th>
					<th><?php echo _("Color");?></th>
					<th><?php echo _("Size");?></th>
					<th><?php echo _("Unit Price");?></th>
					<th><?php echo _("Discount");?></th>
					<th><?php echo _("Quantity");?></th>
					<th><?php echo _("Total");?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
	<?php foreach($cart as $key=>$each_item){
		$total = $each_item['discount']*$each_item['quantity'];
		echo <<<CART_ITEM
			<tr class="cart_item">
				<td><img class="showcase-thumbnail" src="{$each_item['filepath']}"/></td>
				<td>{$each_item['id']}</td>
				<td>{$each_item['color']}</td>
				<td>{$each_item['size']}</td>
				<td>{$each_item['price']}</td>
				<td>{$each_item['discount']}</td>
				<td>{$each_item['quantity']}</td>
				<td>$total</td>
				<td><a href='#' class='del_item' value='$key'>x</a></td>
			</tr>
CART_ITEM;
		} ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan=8>
						<input type='image' name='button' onclick ="checkout(0);" src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' align='top' alt='Check out with PayPal'/>
						<input type='image' name='button' onclick ="checkout(1);" src='https://img.alipay.com/pa/img/home/logo-alipay-t.png' border='0' align='top' alt='Check out with PayPal'/></span>
					</td>
				</tr>
			</tfoot>
		</table>
		<input type="hidden" name="cl" value="<?php echo count($cart); ?>"/>
	<?php } ?>
</div>
<div class="modal" name="login_modal" style="display:none;"></div>
<script type='text/javascript' src="/js/jquery.json-2.3.min"></script>