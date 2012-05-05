<div>
	<?php echo css('css/login.css') ?>
	<div class="expando">		
		<?php if( $this->input->post('submit') ) echo "<div class='error-panel'>"; ?>
		<?php echo validation_errors(); ?>
		<?php if( $this->input->post('submit') ) echo "</div>"; ?>
		
		<div class='section-header'><?php echo T_("Sign In / Create Account");?></div>
		
		<div class='left-block'>
			<div class='header'><?php echo T_("Existing Customers");?></div>
			<form method="POST" name='login_form' action="login">
				<div class='field'>
					<label for='email' class='label'><?php echo T_("Email");?></label><input type='text' id='email' name='email' value='<?php echo set_value('email'); ?>' class='input' />
				</div>
				<div class='field'>
					<label for='pwd' class='label'><?php echo T_("Password");?></label><input type='password' id='pwd' name='pwd' class='input' />
				</div>
				<div><input type='submit' value='<?php echo T_('Submit') ?>' class='submit-button' /></div>
				<div class='forgot-pwd'><a href='account/forgotten'><?php echo T_("Forgotten Password");?></a></div>
			</form>
		</div>
		
		<div class='right-block'>
			<div class='header'><?php echo T_("New Customer") ?></div>
			<p><?php echo T_("Creating an account provides you with convenient features, including:");?>
				<ul>
					<li>› <?php echo T_("Quick checkout");?></li>
					<li>› <?php echo T_("View and track orders");?></li>
					<li>› <?php echo T_("Add to wish list");?></li>
					<li>› <?php echo T_("Save multiple shipping addresses");?></li>
					<li>› <?php echo T_("Advance notice on latest promotions");?></li>
				</ul>
				<a class='reg-btn' href='register'><?php echo T_("Register");?></a>
			</p>
		</div>
		
		<div class='clear'></div>
	</div>
</div>