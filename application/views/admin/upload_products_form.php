<div id='batch_upload'>
	<?php echo form_open_multipart('admin/products/upload');?>
	<h2><?php echo _('Add products in excel file') ?></h2>
	<input type="hidden" name="action" value="upload" />
	<input type="file" name="userfile" size="20" />

	<br /><br />

	<input type="submit" value="<?php echo _('Upload') ?>" />

	</form>
</div>