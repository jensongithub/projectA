<div id="content" class='container'>
	<div class="content">		
		<div class="container">
			<?php if( $this->input->post('submit') ) echo "<div class='error-panel'>"; ?>			
				<?php echo validation_errors(); ?>
			<?php if( $this->input->post('submit') ) echo "</div>"; ?>
			<?php 
				$attr = array('class' => 'form', 'id' => 'registration-form');
				echo form_open('register', $attr);
			?>
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
								gender: "required"
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
				
				<table>
					<tr>
						<td><label for='email' class='form-label'><?php echo lang('email'); ?></label></td>
						<td><input id='email' name='email' type='email' class='required' value='<?php echo set_value('email'); ?>' /></td>
					</tr>
					<tr>
						<td><label for='firstname' class='form-label'><?php echo lang('firstname'); ?></label></td>
						<td><input id='firstname' name='firstname' class='required' value='<?php echo set_value('firstname'); ?>' /></td>
					</tr>
					<tr>
						<td><label for='lastname' class='form-label'><?php echo lang('lastname'); ?></label></td>
						<td><input id='lastname' name='lastname' class='required' value='<?php echo set_value('lastname'); ?>' /></td>
					</tr>
					<tr>
						<td><label for='pwd' class='form-label'><?php echo lang('pwd'); ?></label></td>
						<td><input id='pwd' name='pwd' type='password' class='required' /></td>
					</tr>
					<tr>
						<td><label for='conpwd' class='form-label'><?php echo lang('conpwd'); ?></label></td>
						<td><input id='conpwd' name='conpwd' type='password' class='required' /></td>
					</tr>
					<tr>
						<td><label for='phone' class='form-label'><?php echo lang('phone'); ?></label></td>
						<td><input id='phone' name='phone' value='<?php echo set_value('phone'); ?>' /></td>
					</tr>
					<tr>
						<td><label for='' class='form-label'><?php echo lang('gender'); ?></label></td>
						<td><input id='gender1' name='gender' type='radio' class='required' value='M' <?php echo set_radio('gender', 'M'); ?> /><label for='gender1'> <?php echo lang('male', 'gender1'); ?></label> <input id='gender2' name='gender' type='radio' value='F' <?php echo set_radio('gender', 'F'); ?> /><label for='gender2'> <?php echo lang('female'); ?></label><label for='gender' class='error'>Please select your gender</label></td>
					</tr>
					<tr>
						<td><input id='submit' name='submit' type='submit' value='<?php echo lang('submit'); ?>' /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>