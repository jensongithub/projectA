<div id="content" class='container'>
	<div class="expando">
		<?php if( $this->input->post('submit') ) echo "<div class='error-panel'>"; ?>
		<?php echo validation_errors(); ?>
		<?php if( $this->input->post('submit') ) echo "</div>"; ?>
		
		<h3><?php echo _("Sign In / Create Account");?></h3>
		<div class='left-block'>
			<div class='header'><?php echo _("Existing Customers");?></div>
			<form method="POST" name='login_form' action="login">
				<div class='row'>
					<label><?php echo _("Email");?></label><input type='text' name='email' value='<?php echo set_value('email'); ?>'/>
				</div>
				<div class='row'>
					<label><?php echo _("Password");?></label><input type='password' name='pwd' />
				</div>
				<div><a href=''><?php echo _("Forgotten Password");?></a></div>
				<div><input type='submit' value='Submit' /><input type='button' value='Reset' /></div>
			</form>
		</div>
		<div class='right-block'>
			<div class='header'><?php echo _("New Customer");?></div>
			<p><?php echo _("Creating an account provides you with convenient features, including:");?></p>
				<ul>
					<li>› <?php echo _("Quick checkout");?></li>
					<li>› <?php echo _("View and track orders");?></li>
					<li>› <?php echo _("Add to wish list");?></li>
					<li>› <?php echo _("Save multiple shipping addresses");?></li>
					<li>› <?php echo _("Advance notice on latest promotions");?></li>
				</ul>
				<center><a class='reg-btn' href='register'><?php echo _("Register");?></a></center>
			</p>
		</div>
	</div>
</div>