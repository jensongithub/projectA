<?php echo js('jquery-validation-1.9.0/jquery.validate.min.js'); ?>
<?php echo css('css/admin/categories.css') ?>

<h2>Categories</h2>
<div id='categories-list-panel'>
	<select id='categories-list' size='10'>
		<?php 
		$i = 1;
		foreach( $page['categories'] as $cat ){ ?>
		<option id='<?php echo "cat$i" ?>' value='<?php echo $cat['id'] ?>'><?php echo $cat['id'] . ' | ' . $cat['name'] ?></option>
		<?php $i++; } ?>
	</select>
	
	<script type='text/javascript'>
		var action = '<?php echo $page['action'] ?>';
		var cat = <?php echo $page['cat_json'] ?>;
		var holder;
		
		$(document).ready(function(){
			$('#categories-list').change(function(){
				holder = cat[$(this).find("option:selected").attr('id')];
				$('#ori-catname').val( holder.name );
				$('#catid').val( holder.id );
				$('#catname-e').val(holder.name );
				$('#path-e').val( holder.path );
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
		<div class='field'>
			<label for='catname-a' class='label'><?php echo _('Category name') ?></label>
			<input id='catname-a' name='catname-a' size='50' value='<?php if( validation_errors() != "" ) echo set_value('catname-a'); ?>' class='input' />
		</div>
		<div class='field'>
			<label for='path-a' class='label'><?php echo _('Path') ?></label>
			<input id='path-a' name='path-a' size='50' value='<?php if( validation_errors() != "" ) echo set_value('path-a'); ?>' class='input' />
		</div>
		<input type='submit' value='<?php echo _('Submit') ?>' class='submit-button' />
	</form>
	
	<form id='category-edit-form' action='edit_categories' method='post' class='form'>
		<input type='hidden' id='action' name='action' value='edit' />
		<input type='hidden' id='catid' name='catid' value='<?php echo set_value('catid'); ?>' />
		<h3>Edit category</h3>
		<div class='field'>
			<label class='label'><?php echo _('Original category') ?></label>
			<input id='ori-catname' name='ori-catname' size='50' value='<?php if( validation_errors() != "" ) echo set_value('ori-catname'); ?>' class='input' />
		</div>
		<div class='field'>
			<label for='catname-e' class='label'><?php echo _('New category name') ?></label>
			<input id='catname-e' name='catname-e' size='50' value='<?php if( validation_errors() != "" ) echo set_value('catname-e'); ?>' class='input' />
		</div>
		<div class='field'>
			<label for='path-e' class='label'><?php echo _('Path') ?></label>
			<input id='path-e' name='path-e' size='50' value='<?php if( validation_errors() != "" ) echo set_value('path-e'); ?>' class='input' />
		</div>
		<input type='submit' value='<?php echo _('Submit') ?>' class='submit-button' />
	</form>
</div>