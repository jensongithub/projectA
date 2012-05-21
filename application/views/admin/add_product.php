<?php echo css('css/admin/products.css'); ?>
<?php if( isset( $page['error'] ) ){ ?>
<div class='error'>
	<p>Operation failed, please contact the support staff.</p>
</div>
<?php } ?>
<?php if( isset( $page['success'] ) ){ ?>
<div class='success'>
	<p>Product added.</p>
</div>
<?php } ?>
<div>
	<script type='text/javascript'>
	var product = {"id":"","name_en":null,"name_zh":null,"description_en":null,"description_zh":null,"front_img":null,"back_img":null,"detail_1_img":null,"detail_2_img":null,"priority":"1","cost":null,"price":null,"discount":null,"components":"[]","status":"N","created_time":null,"created_user":null,"modified_time":null,"modified_user":null};
	var components = eval( '(' + product.components + ')' );
	var categories = eval(<?php echo json_encode($page['categories']) ?>);
	
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
		searchComponents();
		
		// color
		$('.color-thumbnail').click(function(){
			$('.color-thumbnail').removeClass('color-selected');
			$(this).addClass('color-selected');
		});
		
		$('#product-form').submit(function(){
			constructComponentJson();
			//$('#front_img').val( product.id + $('.color-selected').attr('alt') + '-F_s.jpg' );
			//return false;
		});
	}
	
	function count(obj) { return Object.keys(obj).length; }

	function addSelectComponents(value, per){
		var comp = $('.comp-item:last').clone();
		comp.find('.comp-selection option[value=' + value + ']').attr('selected', 'selected');
		comp.children('input[type=number]').val(per);
		comp.children('img').click(function(){
			if( $('.comp-selection').length > 1 )
				comp.remove();
		});
		$('#components-list').append( comp );
	}
	
	function constructComponentJson(){
		var selection = $('.comp-item');
		var arr = {};
		$(selection).each(function(key){
			arr[$(this).find('option:selected').val()] = $(this).find('input[type=number]').val();
		});
		
		var json = JSON.stringify(arr);
		var obj = eval('obj = ' + json);
		$('#components').val(JSON.stringify(obj));
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
			
			$.each(components, function(key, val){
				addSelectComponents(key, val);
			});
			if( count( components ) > 0 ){
				$('.comp-item:first').remove();
			}
		});
	}
	</script>

	<div class='clear'>
		<?php echo $page['back'] ?>
	</div>

	<form id='product-form' method='post'>
		<input type='hidden' name='action' value='add' />
		<input type='hidden' id='components' name='components' />
		<input type='hidden' id='front_img' name='front_img' />

		<div class='field'>
			<label for='cat' class='label'>Category</label>
			<select id='cat' name='cat' class='input'>
			<?php foreach( $page['categories'] as $cat ){
				if( stripos( $cat['name'], 'sales' ) === FALSE ){ ?>
				<option value='<?php echo $cat['id'] ?>'><?php echo $cat['name'] ?></option>
			<?php } } ?>
			</select>
			<p class='hint'>The category which this product belongs to</p>
		</div>
		<div class='field'>
			<label for='id' class='label'>Product code</label>
			<input id='id' name='id' class='input' />
		</div>
		<div class='field'>
			<label for='name_en' class='label'>Product name</label>
			<input id='name_en' name='name_en' class='input' />
			<p class='hint'>Product name</p>
		</div>
		<div class='field'>
			<label for='name_zh' class='label'>Product name (Chinese)</label>
			<input id='name_zh' name='name_zh' class='input' />
			<p class='hint'>Product name in Chinese</p>
		</div>
		<div class='field'>
			<label for='priority' class='label'>Priority</label>
			<input id='priority' name='priority' type='number' min='1' max='99' maxlength='2' class='short-input' value='1' />
			<p class='hint'>Display priority, the higher priority shows first.</p>
		</div>
		<div class='field'>
			<label for='price' class='label'>Price</label>
			HK$ <input id='price' name='price' type='number' min='0' max='9999' maxlength='5' class='short-input' />
			<p class='hint'>Product price</p>
		</div>
		<div class='field'>
			<label for='discount' class='label'>Discount</label>
			HK$ <input id='discount' name='discount' type='number' min='0' max='9999' maxlength='5' class='short-input' /> 
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
							<select class='comp-selection'>
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
			<textarea id='description_en' name='description_en' class='input' ></textarea>
			<p class='hint'>Product description</p>
		</div>
		<div class='field'>
			<label for='description_zh' class='label'>Description (Chinese)</label>
			<textarea id='description_zh' name='description_zh' class='input'></textarea>
			<p class='hint'>Product description in Chinese</p>
		</div>
		
		<input type="submit" class="button" value="Submit" />
	</form>
	<!--
	<div id='product-image-panel'>
		<h3 class='label'><?php echo _('Product thumbnail') ?></h3>
		<div class='clear'></div>
		<div>
			<?php
			if( isset($page['category']) ){
				foreach( $page['color'] as $color ){
			?>
				<div class='color-selection'>
					<?php
					$config = array(
						'src' => "products/" . $page['category']['path'] . "/" . $page['product']['id'] . $color['color'] . "-F_s.jpg",
						'class' => 'color-thumbnail clickable',
						'alt' => $color['color']
					);
					if( substr($page['product']['front_img'], 6, 6 ) == $color['color'] )
						$config['class'] .= ' color-selected';

					echo img($config);
					?>
				</div>
			<?php
				}
			}
			else{
				echo "You must assign a category for this product before you can view the thumbnail(s).";
			}
			?>
		</div>
	</div>
	-->
</div>