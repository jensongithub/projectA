<div id='batch_upload'>
	<?php echo form_open_multipart('admin/products/upload');?>
	<h2><?php echo _('Add products in excel file') ?></h2>
	<input type="hidden" name="upload" value="1" />
	<input type="file" name="userfile" size="20" />

	<br /><br />

	<input type="submit" value="<?php echo _('Upload') ?>" />

	</form>
</div>
<hr style='margin: 10px 0 20px 0;' />