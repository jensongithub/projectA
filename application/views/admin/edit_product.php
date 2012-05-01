<?php
	if( isset($product) ){
		print_r($product);
		echo strlen($product['description_en']);
	}
?>
<div>
	<style>
	#product-form {
		width: 500px;
		padding: 20px;
		background: #f0f0f0;
		overflow:auto;

		/* Border style */
		border: 1px solid #cccccc;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border-radius: 7px;

		/* Border Shadow */
		-moz-box-shadow: 2px 2px 2px #cccccc;
		-webkit-box-shadow: 2px 2px 2px #cccccc;
		box-shadow: 2px 2px 2px #cccccc;
	}
	
	.label {
		text-shadow: 2px 2px 2px #ccc;
		display: block;
		float: left;
		font-size: 14px;
		font-weight: bold;
		margin-right:10px;
		text-align: right;
		width: 120px;
		line-height: 25px;
	}
	
	textarea {
		resize: none;
		height: 80px;
	}
	
	.input {
		font-family: Arial, Verdana;
		font-size: 15px;
		padding: 5px;
		border: 1px solid #b9bdc1;
		width: 300px;
		color: #333;
	}
	
	.short-input {
		width: 70px;
	}
	
	.comp-selection {
		font-family: Arial, Verdana;
		font-size: 15px;
		padding: 2px;
		border: 1px solid #b9bdc1;
		width: 200px;
		color: #333;
	}
	
	.radio {
		margin: 5px 30px 5px 0;
	}
	
	.hint{
		display:none;
	}
	
	.field {
		clear: both;
		margin: 5px;
	}
	
	.field:hover .hint {
		position: absolute;
		display: block;
		margin: -30px 0 0 455px;
		color: #FFFFFF;
		padding: 7px 10px;
		background: rgba(0, 0, 0, 0.6);

		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border-radius: 7px;
	}
	
	.button{
		float: right;
		margin:10px 55px 10px 0;
		font-weight: bold;
		line-height: 1;
		padding: 6px 10px;
		cursor:pointer;
		color: #fff;

		text-align: center;
		text-shadow: 0 -1px 1px #64799e;

		/* Background gradient */
		background: #a5b8da;
		background: -moz-linear-gradient (top, #a5b8da 0%, #7089b3 100%);
		background: -webkit-gradient (linear, 0% 0%, 0% 100%, from(#a5b8da), to(#7089b3));

		/* Border style */
		border: 1px solid #5c6f91;
		-moz-border-radius: 10px;
		-webkit-border-radius: 10px;
		border-radius: 10px;

		/* Box shadow */
		-moz-box-shadow: inset 0 1px 0 0 #aec3e5;
		-webkit-box-shadow: inset 0 1px 0 0 #aec3e5;
		box-shadow: inset 0 1px 0 0 #aec3e5;
	}
	
	.clickable {
		cursor: pointer;
	}
	
	#add-button {
		padding-left: 5px;
		width: 15px;
		height: 15px;
	}
	</style>
	<script type='text/javascript'>
	var product = eval(<?php echo json_encode($product) ?>);
	var components = eval( '(' + product.components + ')' );
	
	$(document).ready(function(){
		initProductForm();
	});

	function initProductForm(){
		// number range
		$('#priority-range').change(function(){
			$('#priority').val($(this).val());
		});
		
		$('#price-range').change(function(){
			$('#price').val($(this).val());
		});
		
		$('#price').change(function(){
			$('#discount').val( Math.ceil( parseInt($('#discount-range').val()) * parseFloat($(this).val()) / 100 ) );
		});
		$('#price').keyup(function(){
			$('#discount').val( Math.ceil( parseInt($('#discount-range').val()) * parseFloat($(this).val()) / 100 ) );
		});
		$('#price').keypress(function(){
			$('#discount').val( Math.ceil( parseInt($('#discount-range').val()) * parseFloat($(this).val()) / 100 ) );
		});
		
		$('#discount-range').change(function(){
			$('#discount').val( Math.ceil( parseInt($(this).val()) * parseFloat($('#price').val()) / 100 ) );
		});
		$('#discount-range').keyup(function(){
			$('#discount').val( Math.ceil( parseInt($(this).val()) * parseFloat($('#price').val()) / 100 ) );
		});
		$('#discount-range').keypress(function(){
			$('#discount').val( Math.ceil( parseInt($(this).val()) * parseFloat($('#price').val()) / 100 ) );
		});
		
		$('#discount').change(function(){
			$('#discount-range').val( Math.ceil( parseInt($(this).val()) / parseFloat($('#price').val()) * 100 ) );
		});
		$('#discount').keyup(function(){
			$('#discount-range').val( Math.ceil( parseInt($(this).val()) / parseFloat($('#price').val()) * 100 ) );
		});
		$('#discount').keypress(function(){
			$('#discount-range').val( Math.ceil( parseInt($(this).val()) / parseFloat($('#price').val()) * 100 ) );
		});
		$('#discount').change();
		
		// status radio
		$("input[type='radio'][value='" + product.status + "']").attr('checked', 'checked');

		// components
		$('#add-button').click(function(){
			addSelectComponents('', 0);
		});
		$.each(components, function(key, val){
			addSelectComponents(key, val);
		});
		if( count( components ) > 0 ){
			$('.comp-item:first').remove();
		}
		
		searchComponents();
	}
	
	function count(obj) { return Object.keys(obj).length; }

	function addSelectComponents(value, per){
		var comp = $('.comp-item:last').clone();
		var option = comp.find('option[value=' + value + ']');
		alert(value);
		option.attr('selected', 'selected');
		comp.children('input[type=number]').val(per);
		comp.children('img').click(function(){
			comp.remove();
		});
		$('#components-list').append( comp );
	}

	function searchComponents(){
		$.ajax({
			url: "<?php echo site_url() . "worker/get_components/" ?>"
		}).done(function(data){
			var json = eval("json = " + data);
			var selection = $('.comp-selection');
			$.each(json, function(i, item){
				selection.append("<option value='" + item.id + "'>" + item.name_en + " | " + item.name_zh + "</option>");
			});
		});
	}
	</script>
	<form id='product-form' method='post'>
		<input type='hidden' name='action' value='edit' />

		<div class='field'>
			<label for='id' class='label'>Product code</label>
			<input id='id' name='id' class='input' readonly='readonly' value='<?php echo $product['id'] ?>' />
		</div>
		<div class='field'>
			<label for='name_en' class='label'>Product name</label>
			<input id='name_en' name='name_en' class='input' value='<?php echo $product['name_en'] ?>' />
			<p class='hint'>Product name</p>
		</div>
		<div class='field'>
			<label for='name_zh' class='label'>Product name (Chinese)</label>
			<input id='name_zh' name='name_zh' class='input' value='<?php echo $product['name_zh'] ?>' />
			<p class='hint'>Product name in Chinese</p>
		</div>
		<div class='field'>
			<label for='priority' class='label'>Priority</label>
			<input id='priority' name='priority' type='number' min='1' max='99' maxlength='2' class='short-input' value='<?php echo $product['priority'] ?>' />
			<!--<input id='priority-range' type='range' min='1' max='99' class='input' value='<?php echo $product['priority'] ?>' />-->
			<p class='hint'>Display priority, the higher priority shows first.</p>
		</div>
		<div class='field'>
			<label for='price' class='label'>Price</label>
			HK$ <input id='price' name='price' type='number' min='0' max='9999' maxlength='5' class='short-input' value='<?php echo $product['price'] ?>' />
			<!--<input id='price-range' type='range' min='0' max='9999' class='input' value='<?php echo $product['price'] ?>' />-->
			<p class='hint'>Product price</p>
		</div>
		<div class='field'>
			<label for='discount' class='label'>Discount</label>
			HK$ <input id='discount' name='discount' type='number' min='0' max='9999' maxlength='5' class='short-input' value='<?php echo $product['discount'] ?>' /> 
			<input id='discount-range' type='number' min='0' max='100' class='short-input' value='100' /> %
			<p class='hint'>Price after discount</p>
		</div>
		<div class='field'>
			<table>
				<tr>
					<td style='vertical-align: top'>
						<label class='label'>Components<span class='clickable'><?php echo img( array( 'src' => 'plus.png', 'id' => 'add-button') ) ?></span></label>
					</td>
					<td id='components-list'>
						<div class='comp-item'>
							<select name='components[]' class='comp-selection'>
							</select>
							<input type='number' id='' min='1' max='100' class='short-input' />
							<?php echo img( array( 'src' => 'cross.png', 'id' => 'add-button', 'class' => 'clickable') ) ?>
						</div>
					</td>
				</tr>
			</table>
			<p class='hint'>The components of the product</p>
		</div>
		<div class='field'>
			<label for='status' class='label'>Status</label>
			<p style='padding: 5px;'>
				<label class='radio'><input name='status' type='radio' value='A' /> A</label>
				<label class='radio'><input name='status' type='radio' value='S' /> S</label>
				<label class='radio'><input name='status' type='radio' value='F' /> F</label>
				<label class='radio'><input name='status' type='radio' value='N' /> N</label>
			</p>
			<p class='hint'>Product status ( A: Available, S: On Sales, F: Off Shelf, N: Not Available )</p>
		</div>
		<div class='field'>
			<label for='description_en' class='label'>Description</label>
			<textarea id='description_en' name='description_en' class='input' ><?php echo $product['description_en'] ?></textarea>
			<p class='hint'>Product description</p>
		</div>
		<div class='field'>
			<label for='description_zh' class='label'>Description (Chinese)</label>
			<textarea id='description_zh' name='description_zh' class='input'><?php echo $product['description_zh'] ?></textarea>
			<p class='hint'>Product description in Chinese</p>
		</div>
		
		<input type="submit" class="button" value="Submit" />
	</form>
</div>