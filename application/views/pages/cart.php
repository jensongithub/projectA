<div id="content" class='container'>
	<?php if (empty($this->data['cart'])){ ?>
		<div><?php echo _("No items"); ?></div>
	<?php }else{ ?>
	
		<table border=1>
			<thead>
				<tr>
					<td><?php echo _("Product Code");?> </td>
					<td><?php echo _("Color");?></td>
					<td><?php echo _("Size");?></td>
					<td><?php echo _("Unit Price");?></td>
					<td><?php echo _("Discount");?></td>
					<td><?php echo _("Quantity");?></td>
					<td><?php echo _("Total");?></td>
				</tr>
			</thead>
			<tbody>
			
	
	<?php foreach($cart as $each_item){
		$total = ($each_item['price']-$each_item['discount'])*$each_item['quantity'];
		echo <<<CART_ITEM
			<tr>
				<td>{$each_item['id']}</td>
				<td>{$each_item['color']}</td>
				<td>{$each_item['size']}</td>
				<td>{$each_item['price']}</td>
				<td>{$each_item['discount']}</td>
				<td>{$each_item['quantity']}</td>
				<td>$total</td>
			</tr>
CART_ITEM;
		} ?>
			</tbody>
		</table>
	<?php } ?>
</div>
