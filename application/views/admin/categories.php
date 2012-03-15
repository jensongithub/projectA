<?php echo js('jquery-validation-1.9.0/jquery.validate.min.js'); ?>
<?php echo css('css/admin/categories.css') ?>

<div id='categories-list-panel'>
	<select id='categories-list' size='10'>
		<?php foreach( $categories as $cat ){ ?>
		<option value='<?php echo $cat['id'] ?>'><?php echo $cat['name'] ?></option>
		<?php } ?>
	</select>
	
	<script type='text/javascript'>
		var action = '<?php echo $action ?>';
		
		$(document).ready(function(){
			$('#categories-list').change(function(){
				$('#ori-catname').val( $(this).find("option:selected").text() );
				$('#catid').val( $(this).val() );
				$('#catname-e').val( $(this).find("option:selected").text() );
				$('#category-edit-form').click();
				$('#catname-e').focus();
				$('#catname-e').select();
			});
			
			$('#category-add-form').click(function(){
				$('#category-edit-form input').attr('disabled', 'disabled');
				$('#category-add-form input').removeAttr('disabled');
			});
			
			$('#category-edit-form').click(function(){
				$('#category-add-form input').attr('disabled', 'disabled');
				$('#category-edit-form input').removeAttr('disabled');
				$('#ori-catname').attr('disabled', 'disabled');
			});
			
			$('#category-edit-form').submit(function(){
				$('#ori-catname').removeAttr('disabled');
			})
			
			if( action == 'edit' ){
				$('#category-edit-form').click();
			} else {
				$('#category-add-form').click();
			}
		});
		
	</script>
</div>

<div id='forms-panel'>
	<?php 
	if( validation_errors() != "" ) {
		echo "<div class='error-panel'>" . validation_errors(). "</div>";
	}
	?>
	
	<form id='category-add-form' action='edit_categories' method='post' class='form'>
		<input type='hidden' id='action' name='action' value='add' />
		<h3>Add new category</h3>
		<p><label for='catname-a'><?php echo _('Category name') ?></label></p>
		<p><input id='catname-a' name='catname-a' size='50' value='<?php if( validation_errors() != "" ) echo set_value('catname-a'); ?>' /></p>
		<p><input type='submit' value='<?php echo _('Submit') ?>' /></p>
	</form>
	
	<form id='category-edit-form' action='edit_categories' method='post' class='form'>
		<input type='hidden' id='action' name='action' value='edit' />
		<input type='hidden' id='catid' name='catid' value='<?php echo set_value('catid'); ?>' />
		<h3>Edit category</h3>
		<p><?php echo _('Original category') ?></p>
		<p><input id='ori-catname' name='ori-catname' size='50' value='<?php if( validation_errors() != "" ) echo set_value('ori-catname'); ?>' /></p>
		<p><label for='catname-e'><?php echo _('New category name') ?></label></p>
		<p><input id='catname-e' name='catname-e' size='50' value='<?php if( validation_errors() != "" ) echo set_value('catname-e'); ?>' /></p>
		<p><input type='submit' value='<?php echo _('Submit') ?>' /></p>
	</form>
</div>