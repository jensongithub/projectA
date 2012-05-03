<?php
	echo css('css/admin/components.css');
?>
<script type='text/javascript'>
var temp = {"obj": <?php echo json_encode($page['components']) ?> };

var components = new Array();
for( var i = 0; temp.obj[i]; i++ ){
	components[temp.obj[i].id] = { 'name_en' : temp.obj[i].name_en, 'name_zh' : temp.obj[i].name_zh};
}
delete temp;

function initCompSelect(){
	$('#components-list').click(function(){
		var ep = $('#edit-panel');
		var id = $(this).find('option:selected').val();
		ep.find('#cid').val( id );
		ep.find('#name_en').val( components[id].name_en );
		ep.find('#name_zh').val( components[id].name_zh );
	});
}

function initAddForm(){
	var form = $('#add-panel > form');
	form.submit(function(){
		if( $.trim( form.find('#cid').val() ) == '' || $.trim( form.find('#name_en').val() ) == '' || $.trim( form.find('#name_zh').val() ) == '' ){
			alert('All fields should have value, please check your input.');
			return false;
		}
		else if( components[ $.trim( form.find('#cid').val() ) ] ){
			alert('Short code already existed, it should be distinct.');
			return false;
		}
	});
}

function initEditForm(){
	var form = $('#edit-panel > form');
	form.submit(function(){
		if( $.trim( form.find('#cid').val() ) == '' || $.trim( form.find('#name_en').val() ) == '' || $.trim( form.find('#name_zh').val() ) == '' ){
			alert('All fields should have value, please check your input.');
			return false;
		}
		else if( ! components[ $.trim( form.find('#cid').val() ) ] ){
			alert('Short code does not exist, please choose from the list on the left.');
			return false;
		}
	});
}

$(document).ready(function(){
	initCompSelect();
	initAddForm();
	initEditForm();
});
</script>
<?php if( isset($page['error']) ){ ?>
	<div class='error-panel'><?php echo $page['error'] ?></div>
<?php } ?>
<div>
	<h2><?php echo _('Components') ?></h2>
	<div class='left-panel'>
		<select id='components-list' size='10'>
			<?php foreach( $page['components'] as $comp ){ ?>
				<option value='<?php echo $comp['id'] ?>'><?php echo $comp['id'] ?> - <?php echo $comp['name_en'] ?> | <?php echo $comp['name_zh'] ?></option>
			<?php } ?>
		</select>
	</div>
	
	<div class='right-panel'>
		<div id='add-panel'>
			<h3>Add</h3>
			<?php echo form_open_multipart('admin/components');?>
				<input type='hidden' name='action' value='add' />
				<div class='field'>
					<label for='cid' class='label'>Short code</label><input id='cid' name='cid' class='input' />
				</div>
				<div class='field'>
					<label for='name_en' class='label'>Name</label><input id='name_en' name='name_en' class='input' />
				</div>
				<div class='field'>
					<label for='name_zh' class='label'>Name (Chinese)</label><input id='name_zh' name='name_zh' class='input' />
				</div>
				<input type='submit' value='<?php echo _('Add') ?>' class='submit-button' />
			</form>
		</div>
		
		<div id='edit-panel'>
			<h3>Edit</h3>
			<?php echo form_open_multipart('admin/components');?>
				<input type='hidden' name='action' value='edit' />
				<div class='field'>
					<label for='cid' class='label'>Short code</label><input id='cid' name='cid' class='input' readonly='readonly' />
				</div>
				<div class='field'>
					<label for='name_en' class='label'>Name</label><input id='name_en' name='name_en' class='input' />
				</div>
				<div class='field'>
					<label for='name_zh' class='label'>Name (Chinese)</label><input id='name_zh' name='name_zh' class='input' />
				</div>
				<input type='submit' value='<?php echo _('Edit') ?>' class='submit-button' />
			</form>
		</div>
	</div>
	
	<div class='clear'></div>
</div>