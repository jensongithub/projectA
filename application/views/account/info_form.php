<?php echo css('css/login.css') ?>
<div id="content" class='container'>
	<div class="content expando">
		<div class="container">
			<script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
				<?php echo js('jquery-validation-1.9.0/jquery.validate.min.js'); ?>
			
				<?php echo validation_errors(); ?>
			
				<script type='text/javascript'>
					$(document).ready(function() {
						$("#profile-form").validate({
							rules: {								
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
								}
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
				<!--?php echo T_('Username'); ?-->
				<?php if (isset($page['success']))
					{ echo T_('Update Successful'); 
				}?>
				<div class='section-header'><?php echo T_('Update Profile'); ?></div>
			<?php
			$attr = array('class' => 'form', 'id' => 'profile-form');
			echo form_open('account', $attr);
			?>
				<table style='width:100%;'>
					<tbody>
					<tr>
						<td><label for='email' class='label'><?php echo T_('Email'); ?></label></td>
						<td><?php echo set_value('email',$user['email']); ?></td>
					</tr>
					<tr>
						<td><label for='firstname' class='label'><?php echo T_('First Name'); ?></label></td>
						<td><?php echo set_value('firstname',$user['firstname']); ?></td>
					</tr>
					<tr>
						<td><label for='lastname' class='label'><?php echo T_('Last Name'); ?></label></td>
						<td><?php echo set_value('lastname',$user['lastname']); ?></td>
					</tr>
					<tr>
						<td><label for='pwd' class='label'><?php echo T_('Password'); ?></label></td>
						<td><input id='pwd' name='pwd' type='password' class='required' /></td>
					</tr>
					<tr>
						<td><label for='conpwd' class='label'><?php echo T_('Confirm Password'); ?></label></td>
						<td><input id='conpwd' name='conpwd' type='password' class='required' /></td>
					</tr>
					<tr>
						<td><label for='phone' class='label'><?php echo T_('Phone'); ?></label></td>
						<td><input id='phone' name='phone' value='<?php echo set_value('phone',$user['phone']); ?>' /></td>
					</tr>
					<tr>
						<td><label for='' class='label'><?php echo T_('Gender'); ?></label></td>
						<td>
							<?php echo set_value('gender',$user['gender']); ?>
						</td>
					</tr>					
					<tr>
						<td></td>
						<td><input id='submit' name='submit' type='submit' value='<?php echo T_('submit'); ?>' /></td>
					</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
</div>