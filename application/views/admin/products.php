<?php echo css('css/admin/products.css') ?>
<?php if( isset($error) ) echo $error;?>
<?php if( isset($success_count) ) echo "<div class='success'>" . _("$success_count record(s) has been modified.") . "</div>" ?>

<div id='batch_upload'>
	<?php echo form_open_multipart('admin/products/upload');?>
	<h2><?php echo _('Add products in excel file') ?></h2>
	<input type="hidden" name="upload" value="1" />
	<input type="file" name="userfile" size="20" />

	<br /><br />

	<input type="submit" value="<?php echo _('Upload') ?>" />

	</form>
</div>
<hr style='margin: 10px 0 20px 0;' />

<form method='post' action=''>
	<input type='hidden' name='move' value='1' />
	<div id="tablewrapper">
		<div id="tableheader">
			<div class="search">
				<select id="columns" onchange="sorter.search('query')"></select>
				<input type="text" id="query" onkeyup="sorter.search('query')" />
			</div>
			<span class="details">
				<div>Records <span id="startrecord"></span>-<span id="endrecord"></span> of <span id="totalrecords"></span></div>
				<div><a href="javascript:sorter.reset()">reset</a></div>
			</span>
		</div>
		
		<div id='operation-panel'>
			<div class='move'>
				<label for=''><?php echo _('Move to') ?></label>
				<select id='' name='cid'>
					<?php foreach( $categories as $cat ){
						echo "<option value='${cat['id']}'>${cat['name']}</option>";
					} ?>
				</select>
				<span><input type='submit' value='<?php echo _('Execute') ?>' /></span>
			</div>
		</div>
		
		<table id='product-table' class='tinytable'>
			<thead>
				<tr>
					<th class='nosort' style='padding: 6px;'><input id='check-all-button' type='checkbox' /></th>
					<th><h3>Category</h3></th>
					<th><h3>Product code</h3></th>
					<th><h3>Name</h3></th>
					<th><h3>Price</h3></th>
					<th><h3>Discount</h3></th>
					<th><h3>Status</h3></th>
					<th><h3>Priority</h3></th>
				</tr>
			</thead>
			
			<tbody>
				<?php
				foreach( $products as $product ){
				?>
				<tr>
					<td><input type='checkbox' name='pid[]' value='<?php echo $product['id'] ?>' /></td>
					<td><?php echo $product['cat_name'] ?></td>
					<td><?php echo anchor('admin/products/edit/' . $product['id'], $product['id']) ?></td>
					<td><?php echo $product['name_zh'] ?></td>
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
		
		<div id="tablefooter">
			<div id="tablenav">
				<div>
					<img src="/images/TinyTableV3/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" />
					<img src="/images/TinyTableV3/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" />
					<img src="/images/TinyTableV3/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" />
					<img src="/images/TinyTableV3/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" />
				</div>
				<div>
					<select id="pagedropdown"></select>
				</div>
				<div>
					<a href="javascript:sorter.showall()">view all</a>
				</div>
			</div>
			<div id="tablelocation">
				<div>
					<select onchange="sorter.size(this.value)">
					<option value="10">10</option>
					<option value="15" selected="selected">15</option>
					<option value="20">20</option>
					<option value="50">50</option>
					<option value="100">100</option>
					</select>
					<span>Entries Per Page</span>
				</div>
				<div class="page">Page <span id="currentpage"></span> of <span id="totalpages"></span></div>
			</div>
		</div>
	</div>
</form>
<?php echo css('css/TinyTableV3.css') ?>
<?php echo js('TinyTableV3/script.js') ?>
<script type="text/javascript">
var sorter = new TINY.table.sorter('sorter','product-table',{
	headclass:'head',
	ascclass:'asc',
	descclass:'desc',
	evenclass:'evenrow',
	oddclass:'oddrow',
	evenselclass:'evenselected',
	oddselclass:'oddselected',
	paginate:true,
	size:15,
	colddid:'columns',
	currentid:'currentpage',
	totalid:'totalpages',
	startingrecid:'startrecord',
	endingrecid:'endrecord',
	totalrecid:'totalrecords',
	hoverid:'selectedrow',
	pageddid:'pagedropdown',
	navid:'tablenav',
	sortcolumn:1,
	sortdir:1,
	columns:[{index:4, format:'$', decimals:0},{index:5, format:'$', decimals:0}],
	init:true
});

$(document).ready(function(){
	$('#check-all-button').click(function(){
		$('tr:visible > td > :checkbox').click();
	});
	$('tr').click(function(){
		$(this).children('td > :checkbox').click();
	});
});

</script>