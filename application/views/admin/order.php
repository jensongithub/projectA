<?php echo css('css/admin/products.css') ?>
<?php if( isset($page['error']) ) echo $page['error'];?>

		<table id='product-table' class='tinytable'>
			<thead>
				<tr>
					<th class='nosort' style='padding: 6px;'><input id='check-all-button' type='checkbox' /></th>
					<th><h3>Product code</h3></th>
					<th class='nosort'><h3>Image</h3></th>
					<th><h3>Price</h3></th>
					<th><h3>Discount</h3></th>
					<th><h3>Status</h3></th>
					<th><h3>Priority</h3></th>
				</tr>
			</thead>
			
			<tbody>
				<?php
				foreach( $page['products'] as $product ){
				?>
				<tr>
					<td><input type='checkbox' name='pid[]' value='<?php echo $product['id'] ?>' /></td>
					<td><?php echo anchor('admin/products/edit/' . $product['id'], $product['id']) ?></td>
					<td>
						<?php if( $page['cid'] ) {
							foreach( $product['colors'] as $color ){
								echo anchor('admin/products/edit/' . $product['id'], img( array('src' => "products/" . $page['categories'][$page['cid']-1]['path'] . "/" . $product['id'] . $color['color'] . '-F_s.jpg', 'class' => 'thumbnail') ) );
							}
						} ?>
					</td>
					<td>$<?php echo $product['price'] ?></td>
					<td>$<?php echo $product['discount'] ?></td>
					<td><?php echo $product['status'] ?></td>
					<td><?php echo $product['priority'] ?></td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		
		