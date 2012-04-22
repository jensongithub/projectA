<div id="content" class='container'>
	<div class="content expando">		
		<?php if( $this->input->post('submit') ) echo "<div class='error-panel'>"; ?>
		<?php echo validation_errors(); ?>
		<?php if( $this->input->post('submit') ) echo "</div>"; ?>
		
		
		<div class='block'>
			<div class='header'><?php echo _("Reset Password");?></div>
			<form method="POST" name='new_password' action="<?php echo site_url().$this->lang->lang(); ?>/account/new_password">
				<div class='row'>
					<label><?php echo _("Password");?></label><input type='password' name='pwd' />
				</div>
				<div class='row'>
					<label><?php echo _("Confirm Password");?></label><input type='password' name='confirm_pwd' />
				</div>
				
				<div><input type='submit' value='Submit' /><input type='button' value='Reset' /></div>
			</form>
		</div>
	</div>
</div>