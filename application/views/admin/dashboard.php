<?php ?>
<style>
.col-1 {
	float: left;
}

.col-2 {
	float: left;
}

.dash-section {
	/* Border style */
	border: 1px solid #cccccc;
	-moz-border-radius: 7px;
	-webkit-border-radius: 7px;
	border-radius: 7px;

	/* Border Shadow */
	-moz-box-shadow: 2px 2px 2px #cccccc;
	-webkit-box-shadow: 2px 2px 2px #cccccc;
	box-shadow: 2px 2px 2px #cccccc;

	background: #f0f0f0;
	display: block;
	float: left;
	margin: 5px;
	min-height: 90px;
	padding: 10px 20px;
	width: 400px;
}

.dash-section:hover {
	background: #f6f6f6;
}
</style>


<div class='dash-section'>
	<h3><?php echo anchor('admin/order', 'Order') ?></h3>
	<p>Maintain your sales orders, including checking order status, its' item list.</p>
</div>

<div class='dash-section'>
	<h3><?php echo anchor('admin/products', 'Products') ?></h3>
	<p>Maintain your products, including uploading excel file, changing product details such as status, price, etc.</p>
</div>

<div class='dash-section'>
	<h3><?php echo anchor('admin/edit_categories', 'Categories') ?></h3>
	<p>Maintain your product categories, including the category name and its image path.</p>
</div>

<div class='dash-section'>
	<h3><?php echo anchor('admin/menu', 'Menu') ?></h3>
	<p>Maintain your site menu, including mapping each category to a unique menu item, changing the display text and the menu sequence.</p>
</div>

<div class='dash-section'>
	<h3><?php echo anchor('admin/components', 'Components') ?></h3>
	<p>Maintain your products' components, to change the name of each component.</p>
</div>