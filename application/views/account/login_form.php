<div>
	<?php echo css('css/login.css') ?>
	<div class="expando">		
		<?php if( $this->input->post('submit') ) echo "<div class='error-panel'>"; ?>
		<?php echo validation_errors(); ?>
		<?php if( $this->input->post('submit') ) echo "</div>"; ?>
		
		<div class='section-header'><?php echo _("Sign In / Create Account");?></div>
		
		<div class='left-block'>
			<div class='header'><?php echo _("Existing Customers");?></div>
			<form method="POST" name='login_form' action="login">
				<div class='field'>
					<label for='email' class='label'><?php echo _("Email");?></label><input type='text' id='email' name='email' value='<?php echo set_value('email'); ?>' class='input' />
				</div>
				<div class='field'>
					<label for='pwd' class='label'><?php echo _("Password");?></label><input type='password' id='pwd' name='pwd' class='input' />
				</div>
				<div><input type='submit' value='Submit' class='submit-button' /></div>
				<div class='forgot-pwd'><a href='account/forgotten'><?php echo _("Forgotten Password");?></a></div>
			</form>
		</div>
		
		<div class='right-block'>
			<div class='header'><?php echo _("New Customer");?></div>
			<p><?php echo _("Creating an account provides you with convenient features, including:");?>
				<ul>
					<li>› <?php echo _("Quick checkout");?></li>
					<li>› <?php echo _("View and track orders");?></li>
					<li>› <?php echo _("Add to wish list");?></li>
					<li>› <?php echo _("Save multiple shipping addresses");?></li>
					<li>› <?php echo _("Advance notice on latest promotions");?></li>
				</ul>
				<a class='reg-btn' href='register'><?php echo _("Register");?></a>
			</p>
		</div>
		
		<div class='clear'></div>
	</div>
</div>