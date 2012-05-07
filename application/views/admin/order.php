<?php echo css('css/admin/products.css') ?>
<?php if( isset($page['error']) ) echo $page['error'];?>
<script>
	var query_obj = {"url":"", "val":{}};
	query_obj.url = "<?php echo $page['search_url']; ?>";
	
</script>
<script>

function set_rownum(val){
	$("input[name=row_num]").val(val);
}

function search_order(){
	var s_key = $('#columns').val();
	var s_value = $('#search_value').val();
	query_obj.val[s_key]=s_value;
	
	var val = $.toJSON(query_obj.val);
	
	var row_num=$("input[name=row_num]").val();
	var howmany=$("select[name=howmany]").val();
	
	$.ajax({
		type: "POST",
		 url: query_obj.url,
		data: "val="+val+"&row_num="+row_num+"&howmany="+howmany,
		dataType: "json",
		success: function (data, textStatus, jqXHR) {
			var obj = jQuery.parseJSON(jqXHR.responseText);
			/*if (obj.cart_item!=''){
				shop_cart.list.push(obj.cart_item);
			}*/
			
			
		},
		error:function(xhr,err){ alert("Please try again later or contact info@casimira.com.hk.");},
		async:false
	});
}
</script>


<h2>Purchase Order</h2>
<hr style='margin: 10px 0 20px 0;' />
<form id='form' method='post' action=''>
	<input type='hidden' id='action' name='action' value='move' />
	<div id="tablewrapper">
		<div id="tableheader">
			<div class="search">
				<select id="columns">
					<option value="orders.payment_date">Payment Date</option>
					<option value="orders.id">Order Number</option>
					<option value="users.email">Email</option>
					<option value="users.contact">Contact Number</option>
					<option value="orders.total_amount">Total Amount</option>
					<option value="orders.is_handled">Is Handled?(y/n)</option>
					<option value="orders.handled_by">Handled By</option>
					<option value="orders.handled_date">Handled Date</option>
					<option value="orders.remarks">Remarks</option>
				</select>
				<input type="text" id="search_value" style="content:sdf" />
			</div>
			<input type='button' onclick='search_order();' name='search' value='Search'/>
		</div>
		
		<table id='order-table' class='tinytable'>
			<thead>
				<tr>
					<th class='nosort' style='padding: 6px;'><input id='check-all-button' type='checkbox' /></th>
					<th><?php echo _("Payment Date");?> </th>
					<th><?php echo _("Order Number");?> </th>
					<th><?php echo _("Buyer");?> </th>
					<th><?php echo _("Email");?> </th>
					<th><?php echo _("Contact Number");?> </th>
					<th><?php echo _("Address");?> </th>
					<th><?php echo _("Total Amount");?></th>
					<th><?php echo _("Is handled?");?></th>
					<th><?php echo _("Handled By");?></th>
					<th><?php echo _("Handled Date");?></th>
					<th><?php echo _("Remarks");?></th>
					<th></th>
				</tr>
			</thead>
			<tbody style="overflow-y:scroll;">
				<?php
				foreach( $page['order'] as $each_row ){
				?>
				<tr>
					<td><input type='checkbox' name='oid[]' value='<?php echo $each_row['id'] ?>' /></td>
					<td><?php echo anchor('admin/order/' . $each_row['id']) ?></td>
					<td><?php echo $each_row['payment_date'] ?></td>
					<td><?php echo $each_row['first_name'].$each_row['last_name'] ?></td>
					<td><?php echo $each_row['email'] ?></td>
					<td><?php echo $each_row['contact number'] ?></td>
					<td><?php echo $each_row['address_street'].",".$each_row['address_zip'].",".$each_row['address_state'].",".$each_row['address_city'].",".$each_row['address_country'].",".$each_row['address_country_code']  ?></td>
					<td><?php echo $each_row['total_amount'] ?></td>
					<td><?php echo $each_row['status'] ?></td>
					<td><?php echo $each_row['is_handled'] ?></td>
					<td><?php echo $each_row['handled_by'] ?></td>
					<td><?php echo $each_row['handled_date'] ?></td>
					<td><?php echo $each_row['remarks'] ?></td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		
		<div id="tablefooter">
			<div id="tablenav">
				<div>
					<img src="/images/TinyTableV3/first.gif" width="16" height="16" alt="First Page" onclick="set_rownum(0); search_order();" />
					<img src="/images/TinyTableV3/previous.gif" width="16" height="16" alt="First Page" onclick="set_rownum(-1); search_order();" />
					<img src="/images/TinyTableV3/next.gif" width="16" height="16" alt="First Page" onclick="set_rownum(1); search_order();" />
					<img src="/images/TinyTableV3/last.gif" width="16" height="16" alt="Last Page" onclick="set_rownum(-2); search_order();" />
					<input type='hidden' name="row_num" value="0" />
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
					<select name='howmany' onchange="search_order();">
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



<script>
function checkAll(){
	$('tr:visible > td > :checkbox').click();
	var checkbox = $('#check-all-button');
	checkbox.unbind('click');
	checkbox.click();
	checkbox.click( checkAll );
}


</script>
<script type='text/javascript' src="/js/jquery.json-2.3.min"></script>
<img class='showcase'>
</img>