<div id="content" class='container'>
	<div class="content expando">
	
			<?php if( $this->input->post('submit') ) echo "<div class='error-panel'>"; ?>
				<?php echo validation_errors(); ?>
			<?php if( $this->input->post('submit') ) echo "</div>"; ?>
				<script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
				<?php echo js('jquery-validation-1.9.0/jquery.validate.min.js'); ?>

				<script type='text/javascript'>
					$(document).ready(function() {
						$("#registration-form").validate({
							rules: {
								email: {
									required: true,
									email: true
								},
								firstname: {
									required: true
								},
								lastname: {
									required: true
								},
								pwd: {
									required: true,
									minlength: 8
								},
								conpwd: {
									required: true,
									equalTo: "#pwd"
								},
								phone: {
									digits: true
								},
								gender: "required",
								read_declaration: "required"
							},
							messages: {
								email: "Please enter a valid email address",
								firstname: "Please enter your firstname",
								lastname: "Please enter your lastname",
								pwd: {
									required: "Please provide a password",
									minlength: "Your password must be at least 8 characters long"
								},
								conpwd: {
									required: "Please provide a password",
									minlength: "Your password must be at least 8 characters long",
									equalTo: "Please enter the same password as above"
								},
								phone: "Please enter a valid phone number",
								gender: "Please select your gender."
							}
						});
					});
				</script>
				<style>
					label.error {
						background: url("images/unchecked.gif") no-repeat 0px 0px;
						color: #F00;
						display: none;
						padding-left: 16px;
					}
				</style>
				<!--?php echo _('Username'); ?-->
			<?php
			$attr = array('class' => 'form', 'id' => 'registration-form');
			echo form_open('register', $attr);
			?>
				<div class='section-header'><?php echo _('Registration'); ?></div>
				<table style='width:100%;'>
					<tr>
						<td><label for='email' class='form-label'><?php echo _('Email'); ?></label></td>
						<td><input id='email' name='email' type='email' class='required' value='<?php echo set_value('email'); ?>' /></td>
					</tr>
					<tr>
						<td><label for='firstname' class='form-label'><?php echo _('First Name'); ?></label></td>
						<td><input id='firstname' name='firstname' class='required' value='<?php echo set_value('firstname'); ?>' /></td>
					</tr>
					<tr>
						<td><label for='lastname' class='form-label'><?php echo _('Last Name'); ?></label></td>
						<td><input id='lastname' name='lastname' class='required' value='<?php echo set_value('lastname'); ?>' /></td>
					</tr>
					<tr>
						<td><label for='pwd' class='form-label'><?php echo _('Password'); ?></label></td>
						<td><input id='pwd' name='pwd' type='password' class='required' /></td>
					</tr>
					<tr>
						<td><label for='conpwd' class='form-label'><?php echo _('Confirm Password'); ?></label></td>
						<td><input id='conpwd' name='conpwd' type='password' class='required' /></td>
					</tr>
					<tr>
						<td><label for='phone' class='form-label'><?php echo _('Phone'); ?></label></td>
						<td><input id='phone' name='phone' value='<?php echo set_value('phone'); ?>' /></td>
					</tr>
					<tr>
						<td><label for='' class='form-label'><?php echo _('Gender'); ?></label></td>
						<td>
							<input id='gender1' name='gender' type='radio' class='required' value='M' <?php echo set_radio('gender', 'M'); ?> />
							<label for='gender1'><?php echo _('male'); ?></label> 
							<input id='gender2' name='gender' type='radio' value='F' <?php echo set_radio('gender', 'F'); ?> />
							<label for='gender2'> <?php echo _('female'); ?></label>
							<label for='gender' class='error'>Please select your gender</label>
						</td>
					</tr>
					<tr>
						<td colSpan=2>
							<div class='form_indent'>
								<input class="checkbox" type="checkbox" name="accept_email"  value="true" id="accept_email"/>
								<label for ='accept_email' style="">
								   <?php echo _("I would like to receive email newsletters and other email based offers relating to casimira's products and services"); ?>
								</label>
								<br/>
								<input class="checkbox" type="checkbox" name="read_declaration"  value="true" id="read_declaration"/>
								<label for='read_declaration' style="">
								   <?php echo sprintf("%s %s %s %s", _('I accept the'), "<a href=''>"._('Terms of Use').'</a>', '&', "<a href=''>"._('Privacy Policy').'</a>'); ?>
								</label>
							</div>
						</td>
					</tr>
					<tr>
						<td><input id='submit' name='submit' type='submit' value='<?php echo _('submit'); ?>' /></td>
					</tr>
				</table>
			</form>
		
	</div>
</div>