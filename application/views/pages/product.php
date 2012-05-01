<div>
	<form action="<?php echo $payment['payment_url']; ?>" METHOD='POST' name="order_form">
<?php
	
	$item_num=1;
	if ($payment['gateway'] ==="paypal"){
?>
		<input type="hidden" name="cmd" value="_cart" />
		<input type="hidden" name="upload" value="1" />
		<input type="hidden" name="business" value="<?php echo $payment['paypal_id']; ?>" />
<?php
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
		<input type="hidden" name="shipping_1" value="0">
		<input type="hidden" name="return" value="<?php echo $payment['success_url'] ?>">
		<input type="hidden" name="cancel_return" value="<?php echo $payment['cancel_url'] ?>">
		<input type="hidden" name="notify_url" value="<?php echo $payment['notify_url'] ?>">
	</form>
<?php }else if($payment['gateway']==="alipay"){ ?>


<?php } ?>
</div>
