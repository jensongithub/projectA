<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta charset="utf-8">
<title>Twitter Bootstrap</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<script src="/js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() { 

}); 
function paypal_submit(){ 
	document.forms["order_form"].action='<?php echo $paypal_url?>'; 
	document.forms["order_form"].submit();
	}
	
function alipay_submit(){ 
	document.forms["order_form"].action='<?php echo $paypal_url?>'; 
	document.forms["order_form"].submit();
	}
</script>
<body>
	<div>
	<form action="" METHOD='POST' name="order_form">
		<input type="hidden" name="cmd" value="_cart" />
		<input type="hidden" name="upload" value="1" />
		<input type="hidden" name="business" value="HAHAH@pp.com" />

<?php
	$shipping = "client address ***";
	$cart_items = array(array("name"=>"basketball", "id"=>"0011", "amount"=>600, "qty"=>3),array("name"=>"football", "id"=>"0021", "amount"=>1200, "qty"=>1));
	
	$item_num=1;
	foreach($cart_items as $each_item):	
?>
		<input type="hidden" name="item_name_<?php echo $item_num; ?>" value="<?php echo $each_item['name']; ?>" />
		<input type="hidden" name="item_number_<?php echo $item_num; ?>" value="<?php echo $each_item['id']; ?>" />
		<input type="hidden" name="amount_<?php echo $item_num; ?>" value="<?php echo $each_item['amount']; ?>" />
		<input type="hidden" name="quantity_<?php echo $item_num; ?>" value="<?php echo $each_item['qty']; ?>" />
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
		<input type='image' name='button' onclick ='paypal_submit();' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' align='top' alt='Check out with PayPal'/>
		<input type='image' name='button' onclick ='alipay_submit();' order_form.submit();});' src='https://img.alipay.com/pa/img/home/logo-alipay-t.png' border='0' align='top' alt='Check out with PayPal'/>
	</form>
	
	</div>
</body>
</html>
