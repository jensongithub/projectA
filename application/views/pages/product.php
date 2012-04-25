<div>
	<form action="<?php echo $payment_url ?>" METHOD='POST' name="order_form">
		<input type="hidden" name="cmd" value="_cart" />
		<input type="hidden" name="upload" value="1" />
		<input type="hidden" name="business" value="HAHAH@pp.com" />
<?php
	$shipping = "client address ***";

	
	$item_num=1;
	if ($payment_gateway ==="paypal"){
		foreach($cart as $each_item):	
?>
		<input type="hidden" name="item_name_<?php echo $item_num; ?>" value="<?php echo $each_item['id'].$each_item['color'].$each_item['size']; ?>" />
		<input type="hidden" name="item_number_<?php echo $item_num; ?>" value="<?php echo $each_item['id']; ?>" />
		<input type="hidden" name="amount_<?php echo $item_num; ?>" value="<?php echo $each_item['price']; ?>" />
		<input type="hidden" name="quantity_<?php echo $item_num; ?>" value="<?php echo $each_item['quantity']; ?>" />
		<?php
			++$item_num;
		endforeach; 
		?>
		<input type="hidden" name="currency_code" value="USD">
		<input type="hidden" name="lc" value="US">
		<input type="hidden" name="rm" value="2">
		<input type="hidden" name="shipping_1" value="<?php echo $shipping; ?>">
		<input type="hidden" name="return" value="shopping-cart-details.php">
		<input type="hidden" name="cancel_return" value="http://lna.localhost/cancel_return">
		<input type="hidden" name="notify_url" value="http://lna.localhost/paypal/paypal_ipn">
	</form>
	<p>
	We are bringing you to Paypal. Please do not close the browser.
	</p>
	<script type="text/javascript">
		document.forms["order_form"].action='<?php echo $payment_url?>'; 
		document.forms["order_form"].submit();
	</script>
<?php }else if($payment_gateway==="alipay"){ ?>


<?php } ?>
</div>
