<div id="content" class='container'>
	<div class="content expando">
		<?php if( $this->input->post('submit') ) echo "<div class='error-panel'>"; ?>
		<?php echo validation_errors(); ?>
		<?php if( $this->input->post('submit') ) echo "</div>"; ?>
		<div class='section-header'><?php echo _("Forgotten Login");?></div>
		<div class='block'>
			<div class='header'><?php echo _("Please Enter your email address");?></div>
			<form method="POST" name='forgotten_form' action="forgotten">
				<div class='row'>
					<label><?php echo _("Email");?></label><input type='text' name='email' value='<?php echo set_value('email'); ?>'/>
				</div>				
				<div><input type='submit' value='Submit' /><input type='button' value='Reset' /></div>
			</form>
		</div>		
	</div>
</div>