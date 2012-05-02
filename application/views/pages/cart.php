
<script type='text/javascript'>
$(function(){
	shop_cart.cur_item = new shop_cart.item;
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
		</table>
	<?php } ?>
</div>
<script type='text/javascript' src="/js/jquery.json-2.3.min"></script>