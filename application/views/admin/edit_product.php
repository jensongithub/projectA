<?php
	if( isset($product) ){
		print_r($product);
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
		font-family: Arial, Verdana;
		text-shadow: 2px 2px 2px #ccc;
		display: block;
		float: left;
		font-size: 15px;
		font-weight: bold;
		margin-right:10px;
		text-align: right;
		width: 120px;
		line-height: 25px;
	}
	
	textarea {
		height: 80px;
		resize: none;
	}
	
	.input {
		font-family: Arial, Verdana;
		font-size: 15px;
		padding: 5px;
		border: 1px solid #b9bdc1;
		width: 300px;
		color: #333;
	}
	
	.radio {
		margin: 5px 30px 5px 0;
	}
	
	.hint{
		display:none;
	}
	
	.field {
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
	</style>
	<script type='text/javascript'>
	$(document).ready(function(){
		initProductForm();
	});
	
	function initProductForm(){
		$('#priority-range').change(function(){
			$('#priority').val($(this).val());
		});
		
		$('#price-range').change(function(){
			$('#price').val($(this).val());
		});
		
		$('#discount-range').change(function(){
			$('#discount').val($(this).val());
		});
	}
	</script>
	<form id='product-form'>
		<div class='field'>
			<label for='id' class='label'>Product code</label>
			<input id='id' name='id' class='input' readonly='readonly' value='<?php echo $product['id'] ?>' />
		</div>
		<div class='field'>
			<label for='name' class='label'>Product name</label>
			<input id='name' name='name' class='input' value='<?php echo $product['name'] ?>' />
			<p class='hint'>Product name</p>
		</div>
		<div class='field'>
			<label for='priority' class='label'>Priority</label>
			<input id='priority' name='priority' type='number' min='1' max='99' maxlength='2' value='<?php echo $product['priority'] ?>' />
			<input id='priority-range' type='range' min='1' max='99' class='input' value='<?php echo $product['priority'] ?>' />
			<p class='hint'>Display priority, the higher priority shows first.</p>
		</div>
		<div class='field'>
			<label for='price' class='label'>Price</label>
			<input id='price' name='price' type='number' min='0' max='9999' maxlength='5' value='<?php echo $product['price'] ?>' /> HKD
			<input id='price-range' type='range' min='0' max='9999' class='input' value='<?php echo $product['price'] ?>' />
			<p class='hint'>Product price</p>
		</div>
		<div class='field'>
			<label for='discount' class='label'>Discount</label>
			<input id='discount' name='discount' type='number' min='0' max='9999' maxlength='5' value='<?php echo $product['discount'] ?>' /> HKD
			<input id='discount-range' type='range' min='0' max='100' class='input' value='<?php echo $product['discount'] ?>' />
			<p class='hint'>Price after discount</p>
		</div>
		<div class='field'>
			<label for='components' class='label'>Components</label>
			<input id='components' name='components' class='input' value='<?php echo $product['components'] ?>' />
			<p class='hint'>The components of the product</p>
		</div>
		<div class='field'>
			<label for='status' class='label'>Status</label>
			<p style='padding: 5px;'>
				<label class='radio'><input type='radio' value='A' /> A</label>
				<label class='radio'><input type='radio' value='S' /> S</label>
				<label class='radio'><input type='radio' value='F' /> F</label>
				<label class='radio'><input type='radio' value='N' /> N</label>
			</p>
			<p class='hint'>Product status ( A: Available, S: On Sales, F: Off Shelf, N: Not Available )</p>
		</div>
		<div class='field'>
			<label for='description_en' class='label'>Description</label>
			<textarea id='description_en' name='description_en' class='input' >
				<?php echo $product['description_en'] ?>
			</textarea>
			<p class='hint'>Product description</p>
		</div>
		<div class='field'>
			<label for='description_zh' class='label'>Description (Chinese)</label>
			<textarea id='description_zh' name='description_zh' class='input'>
				<?php echo $product['description_zh'] ?>
			</textarea>
			<p class='hint'>Product description in Chinese</p>
		</div>
		
		<input type="submit" name="Submit"  class="button" value="Submit" />
	</form>
</div>