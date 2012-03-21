
<?php if( isset($error) ) echo $error;?>

<div id='batch_upload'>
	<?php echo form_open_multipart('admin/edit_products');?>
	<h2><?php echo _('Add products in excel file') ?></h2>
	<input type="hidden" name="upload" value="1" />
	<input type="file" name="userfile" size="20" />

	<br /><br />

	<input type="submit" value="<?php echo _('Upload') ?>" />

	</form>
</div>

<div>
	<table>
		<tr>
			<th><input type='checkbox' /></th>
			<th>Category</th>
			<th>Product code</th>
			<th>Name</th>
			<th>Price</th>
			<th>Discount</th>
			<th>Status</th>
			<th>Priority</th>
		</tr>
		
		<?php
		foreach( $products as $product ){
		?>
		<tr>
			<td><input type='checkbox' value='<?php echo $product['id'] ?>' /></td>
			<td></td>
			<td><?php echo $product['id'] ?></td>
			<td><?php echo $product['name'] ?></td>
			<td><?php echo $product['price'] ?></td>
			<td><?php echo $product['discount'] ?></td>
			<td><?php echo $product['status'] ?></td>
			<td><?php echo $product['priority'] ?></td>
		</tr>
		<?php
		}
		?>
	</table>
</div>