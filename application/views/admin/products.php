<div class='content'>
	<?php if( isset($error) ) echo $error;?>

	<?php echo form_open_multipart('worker/upload_product_list');?>

	<input type="file" name="userfile" size="20" />

	<br /><br />

	<input type="submit" value="<?php echo _('Upload') ?>" />

	</form>
</div>