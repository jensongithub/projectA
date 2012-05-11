<?php echo css('css/admin/products.css') ?>
<?php if( isset($page['error']) ) echo $page['error'];?>



<h2>Showing Sales Analysis by <?php echo "";?></h2>
<hr style='margin: 10px 0 20px 0;' />
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
			<div class="search">
				<select id="report_year" name='report_year'>
					<option value="2012" <?php echo set_select('analyse_year', '2012-2013'); ?>>2012-2013</option>
				</select>
				<select id="report_duration" name='report_duration'>
					<option value="this_week" <?php echo set_select('report_duration', 'this_week'); ?>>This week</option>
					<option value="weekly" <?php echo set_select('report_duration', 'weekly'); ?>>Weekly</option>
					<option value="monthly" <?php echo set_select('report_duration', 'monthly'); ?>>Monthly</option>
					<option value="quarterly"<?php echo set_select('report_duration', 'quarterly'); ?>>Quarterly</option>
					<option value="annually" <?php echo set_select('report_duration', 'annually' ); ?>>Yearly</option>
				</select>
				<select id="report_category" name='report_category'>
					<option value="">--Category--</option>
					<?php
					foreach($page['categories'] as $each_row){
						echo "<option value='{$each_row['name']}'". set_select('report_category', $each_row['name']) .">{$each_row['name']}</option>";
					}
					?>
				</select>
				<input type='submit' name='search' value='Search'/>
			</div>
		</div>
		
		<table id='product-table' class='tinytable'>
			<thead>
				<tr>
					<th><h3>Period</h3></th>
					<th><h3>Category</h3></th>
					<th><h3>Total Amount</h3></th>
					<th><h3>Total Cost</h3></th>
					<th><h3>Quantity</h3></th>					
					<th><h3>Net Profit</h3></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach( $page['order'] as $each_row ){
				?>
				<tr>
					<td><?php echo $each_row['period'] ?></td>
					<td><?php echo $each_row['cat_name'] ?></td>
					<td>$<?php echo $each_row['total_amount'] ?></td>
					<td>$<?php echo $each_row['total_cost'] ?></td>
					<td><?php echo $each_row['qty'] ?></td>
					<td>$<?php echo $each_row['total_amount'] - $each_row['total_cost']?></td>
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