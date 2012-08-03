<?php echo css('css/admin/products.css') ?>
<?php if( isset($page['error']) ) echo $page['error'];?>

<div id='add-link'>
	<h3>Or <?php echo anchor('admin/products/add', 'add a new product'); ?></h3>
</div>
<div class='clear'></div>
<hr style='margin: 10px 0 20px 0;' />

<form id='navigation-form' method='get' action='/admin/products/'>
	<div class='navigation'>
		<div>
			<label for=''><?php echo _('View products in') ?> </label>
			<select>
				<option value=''>== Not classified ==</option>
				<?php foreach( $page['categories'] as $cat ){
					echo "<option value='${cat['id']}'>${cat['name']}</option>";
				} ?>
			</select>
			<span><input type='button' value='<?php echo _('View') ?>' /></span>
		</div>
	</div>
	<script type='text/javascript'>
		$('#navigation-form').ready(function(){
			var form = $(this);
			form.attr( 'action', '/admin/products/' );
			form.find('select').change(function(){
				form.attr( 'action', '/admin/products/' + $(this).children('option:selected').val() );
			});
			form.find('input[type=button]').click(function(){
				window.location.href = form.attr('action');
			});
		});
	</script>
</form>

<h2>Showing products in <?php echo ($page['cid']==0)?'unclassified':$page['categories'][$page['cid']-1]['name'] ?></h2>

<form id='form' method='post' action=''>
	<input type='hidden' id='action' name='action' value='move' />
	<div id="tablewrapper">
		<div id="tableheader">
			<div class="search">
				<select id="columns" onchange="sorter.search('query')"></select>
				<input type="text" id="query" onkeyup="sorter.search('query')" />
			</div>
			<span class="details">
				<div>Records <span id="startrecord"></span>-<span id="endrecord"></span> of <span id="totalrecords"></span></div>
				<div><a id='reset-link' href="javascript:sorter.reset()">reset</a></div>
			</span>
		</div>
		
		<div id='operation-panel'>
			<div class='move'>
				<label for=''><?php echo _('Move product(s) to') ?> </label>
				<select id='' name='cid'>
					<?php foreach( $page['categories'] as $cat ){
						echo "<option value='${cat['id']}'>${cat['name']}</option>";
					} ?>
				</select>
				<span><input type='submit' id='category-submit' value='<?php echo _('Execute') ?>' /></span>
			</div>
			<div class='change-status'>
				<label for=''><?php echo _('Change products\'s status to') ?> </label>
				<select id='' name='status'>
					<option value='A'>Available</option>
					<option value='S'>On Sales</option>
					<option value='F'>Off Shelf</option>
					<option value='N'>Not Available</option>
					<option value='D'>Deleted</option>
				</select>
				<span><input type='submit' id='status-submit' value='<?php echo _('Execute') ?>' /></span>
			</div>
		</div>
		
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

function checkAll(){
	$('tr:visible > td > :checkbox').click();
	var checkbox = $('#check-all-button');
	checkbox.unbind('click');
	checkbox.click();
	checkbox.click( checkAll );
}

$(document).ready(function(){
	$('#check-all-button').click( checkAll );

	$('#reset-link').bind('click.checkbox', function(){
		$('td > :checkbox:checked').click();
	});

	$('.thumbnail').hover(function(){
		var img = $('.showcase');
		img.attr('src', $(this).attr('src'));
		$(this).mousemove(function(ent){
			img.css('left', (ent.pageX + 20) );
			img.css('top', (ent.pageY + 20) );
		});
		img.css('display', 'block');
	}, function(){
		$(this).unbind('mousemove');
		$('.showcase').css('display', 'none');
	});
	
	$('#category-submit').click(function(){
		$('#form').find('#action').val('move');
	});
	
	$('#status-submit').click(function(){
		$('#form').find('#action').val('status');
	});
});

</script>

<img class='showcase'>
</img>