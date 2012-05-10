<?php echo css('css/admin/products.css') ?>
<?php if( isset($page['error']) ) echo $page['error'];?>
<script>

var order_obj = {"url":"", "val":{}};
	order_obj.query_url = "<?php echo $page['query_url']; ?>";
	order_obj.save_url = "<?php echo $page['save_url']; ?>";
	
$(function(){ 	
	
	var _curr_pg = $("input[name=_curr_pg]").val();
	var _ttl_pg = $("input[name=_ttl_pg]").val();	
	
	// set the current page number
	$('#_curr_pg').html(_curr_pg);
		
	// set the total page number
	$('#_ttl_pg').html(_ttl_pg);
});
	
</script>
<script>

function set_rownum(val){
	var _curr_pg = $("input[name=_curr_pg]").val();
	var _ttl_pg = $("input[name=_ttl_pg]").val();
	var howmany = $("select[name=howmany]").val();
	

		if (val===1){
			if (_curr_pg <_ttl_pg){
				$("input[name=_row_num]").val(Math.max(_curr_pg-1+val, 0));
				var idx = parseInt(_curr_pg,10)+val;
				$("#pagedropdown").val(idx.toString());
				search_order();
			}
		}else if (val===-1){
			if (_curr_pg >1){
				$("input[name=_row_num]").val(Math.max(_curr_pg-1+val, 0));
				var idx = parseInt(_curr_pg,10)+val;
				$("#pagedropdown").val(idx.toString());
				search_order();
			}
		}else if(val ===0){
			$("input[name=_row_num]").val(0);
			$("#pagedropdown").val('1');
			search_order();
		}else if (val===-2){
			if (_ttl_pg>=howmany){
				$("input[name=_row_num]").val(_ttl_pg-1);
				$("#pagedropdown").val(_ttl_pg);
				search_order();
			}
		}else if (val===-3){
			var pg =$("#pagedropdown").val();
			$("input[name=_row_num]").val(pg-1);
			search_order();
		}
}

function search_order(){
	var s_key = $('#columns').val();
	var s_value = $('#search_value').val();
	order_obj.val={};

	if (s_key!='' && s_value!=''){
		order_obj.val[s_key]=s_value;
	}
	var val = $.toJSON(order_obj.val);
	
	$("input[name=val]").val(val);	
	$("form[name=admin_order_form]").submit();	
}

function save_order(order_id, val){
	
	var flag = confirm('Are you sure to save?');
	
	$.ajax({
		type: "POST",
		 url: order_obj.save_url,
		data: "id="+order_id,
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
	
	return flag;
}
</script>

<h2>Purchase Order</h2>
<hr style='margin: 10px 0 20px 0;' />
<form name='admin_order_form' method='post' action=''>
	<div id="tablewrapper">
		<div id="tableheader">
			<div class="search">
				<select id="columns" name='columns'>
					<option value="orders.payment_date" <?php echo set_select('columns', 'orders.payment_date'); ?>>Payment Date</option>
					<option value="orders.id" <?php echo set_select('columns', 'orders.id'); ?>>Order#</option>
					<option value="users.email"<?php echo set_select('columns', 'orders.email'); ?>>Email</option>
					<option value="users.phone" <?php echo set_select('columns', 'users.phone'); ?>>Phone</option>
					<option value="orders.total_amount" <?php echo set_select('columns', 'orders.total_amount' ); ?>>Total Amount</option>
					<option value="orders.is_handled" <?php echo set_select('columns', 'orders.is_handled'); ?>>Done?(y/n)</option>
					<option value="orders.handle_by" <?php echo set_select('columns', 'orders.handle_by'); ?>>Handle By</option>
					<option value="orders.handle_date" <?php echo set_select('columns', 'orders.handle_date'); ?>>Handle Date</option>
					<!--option value="orders.remarks">Remark</option-->
				</select>
				<input type="text" id="search_value" name='search_value' style="content:sdf" value='<?php echo $this->input->post('search_value') ;// set_value('search_value');?>' />
			</div>
			<input type='submit' onclick='search_order();' name='search' value='Search'/>
		</div>
		
		<table name='order_table' class='tinytable'>
			<thead>
				<tr>
					<!--th class='nosort' style='padding: 6px;'><input id='check-all-button' type='checkbox' /></th-->
					<th><?php echo _("Payment Date");?> </th>
					<th><?php echo _("Order#");?> </th>
					<th><?php echo _("Buyer");?> </th>
					<th><?php echo _("Email");?> </th>
					<th><?php echo _("Phone");?> </th>
					<th><?php echo _("Address");?> </th>
					<th><?php echo _("Total Amount");?></th>
					<th><?php echo _("Payment Status");?></th>
					<th><?php echo _("Done?");?></th>
					<th><?php echo _("Handle By");?></th>
					<th><?php echo _("Handle Date");?></th>
					<!--th><?php //echo _("Remark");?></th-->
				</tr>
			</thead>
			<tbody style="overflow-y:scroll;">
				<?php
				foreach( $page['order'] as $each_row ){
				?>
				<tr>
					<td><?php echo $each_row['payment_date'] ?></td>
					<td><a href='<?php echo site_url().$page['lang'].'/admin/order/'.$each_row['id'] ?>' target='_new'><?php echo $each_row['id'] ?></a></td>
					<td><?php echo $each_row['lastname']." ".$each_row['firstname'] ?></td>
					<td><?php echo $each_row['email'] ?></td>
					<td><?php echo $each_row['phone'] ?></td>
					<td><?php echo $each_row['address_street'].",".$each_row['address_zip'].",".$each_row['address_state'].",".$each_row['address_city'].",".$each_row['country'].",".$each_row['country_code'].",".$each_row['country']  ?></td>
					<td><?php echo $each_row['total_amount'] ?></td>
					<td><?php echo $each_row['status'] ?></td>
					<td><input type='checkbox' name='oid_<?php echo $each_row['id'] ?>' onclick='return save_order(<?php echo $each_row['id'] ?>);' <?php echo $each_row['is_handled']==='1' ? 'checked' : '' ?> /></td>
					<td><?php echo $each_row['handle_by'] ?></td>
					<td><?php echo $each_row['handle_date'] ?></td>
					<!--td><?php //echo $each_row['remark'] ?></td-->
				</tr>
				<?php
				}				
				?>
			</tbody>
		</table>		
		<?php if (isset($page['order_items']) ) { ?>
		<br/>
		<br/>
		<p>Order Item(s)</p>
		<table class='tinytable' name="order_items">
			<thead>
				<tr>
					<th>Order#</th>
					<th>Produce ID</th>
					<th>Picture</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Size</th>
					<th>Color</th>
				</tr>
			</head>
			<tbody>
			<?php foreach( $page['order_items'] as $each_row ){ ?>
				<tr>
					<td><?php echo $each_row['order_id'] ?></td>
					<td><?php echo $each_row['prod_id'] ?></td>
					<td><img class="cart-thumbnail" src='<?php echo site_url().$this->lang->lang().'/'.$each_row['path'].'/'.$each_row['prod_id'].$each_row['color'].'-F_s.jpg'?>'/></td>
					<td><?php echo $each_row['price'] ?></td>
					<td><?php echo $each_row['quantity'] ?></td>
					<td><?php echo $each_row['size'] ?></td>
					<td><?php echo $each_row['color'] ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<?php } ?>
		
		<div id="tablefooter">
			<div id="tablenav">
				<div>
					<img src="/images/TinyTableV3/first.gif" width="16" height="16" alt="First Page" onclick="set_rownum(0);" />
					<img src="/images/TinyTableV3/previous.gif" width="16" height="16" alt="First Page" onclick="set_rownum(-1);" />
					<img src="/images/TinyTableV3/next.gif" width="16" height="16" alt="First Page" onclick="set_rownum(1);" />
					<img src="/images/TinyTableV3/last.gif" width="16" height="16" alt="Last Page" onclick="set_rownum(-2);" />
				</div>
				<div>
					<select id="pagedropdown" name='pagedropdown' onchange="set_rownum(-3); search_order();">
					<?php 
						for($i=1; $i<=$page['total_page_num']; $i++){
							$select = set_select('pagedropdown', "$i");
							echo <<<OPT
								<option value ='$i' $select>$i</option>
OPT;
						}
					?>
					</select>
				</div>
			</div>
			
			<div id="tablelocation">
				<div>Total Row(s): <?php echo $page['total_row'] ;?></div>
				<div>
					<select name='howmany' onchange = "search_order();">
						<option value="1" <?php echo set_select('howmany','1'); ?>>1</option>
						<option value="10" <?php echo set_select('howmany','10'); ?>>10</option>
						<option value="15" <?php echo set_select('howmany','15', true);  ?>>15</option>
						<option value="20" <?php echo set_select('howmany','20'); ?>>20</option>
						<option value="50" <?php echo set_select('howmany','50'); ?>>50</option>
						<option value="100" <?php echo set_select('howmany','100'); ?>>100</option>
					</select>
					<span>Entries Per Page</span>
				</div>
				<div class="page">Page <span id="_curr_pg"></span> of <span id="_ttl_pg"></span></div>
			</div>
		</div>
	</div>
	
	<input type='hidden' name="_row_num" value="0" />
	<input type='hidden' name="_curr_pg" value="<?php echo $page['curr_page_num']; ?>" />
	<input type='hidden' name="_ttl_pg" value="<?php echo $page['total_page_num']; ?>" />
	<input type='hidden' name='val' value="" />
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