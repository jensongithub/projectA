<div id="content" class='container'>
	<div class="content">		
		<div class="container">
			<?php
			/*
				$form['email']['input'] = 
					array(
						'class' => 'form_label',
						'name' => 'email',
						'type' => 'email'
					);
				$form['pwd']['input'] = 
					array(
						'class' => 'form_label',
						'name' => 'pwd',
						'type' => 'password'
					);
				$form['conpwd']['input'] = 
					array(
						'class' => 'form_label',
						'name' => 'conpwd',
						'type' => 'password'
					);
				$form['firstname']['input'] = 
					array(
						'class' => 'form_label',
						'name' => 'firstname'
					);
				$form['lastname']['input'] = 
					array(
						'class' => 'form_label',
						'name' => 'lastname'
					);
				$form['phone']['input'] = 
					array(
						'class' => 'form_label',
						'name' => 'phone'
					);
				$form['gender']['input'] = 
					array(
						'class' => 'form_label',
						'name' => 'gender',
						'type' => 'radio'
					);
				
				echo form_open();
				foreach( $form as $item ) {
					echo form_input($item['input']);
				}
				echo form_close();
			*/
			?>
			<?php echo form_open('register/submit'); ?>
				<table>
					<tr>
						<td><label for='email'>Email</label></td>
						<td><input id='email' name='email' type='email' /></td>
					</tr>
					<tr>
						<td><label for='firstname'>First name</label></td>
						<td><input id='firstname' name='firstname' /></td>
					</tr>
					<tr>
						<td><label for='lastname'>Last name</label></td>
						<td><input id='lastname' name='lastname' /></td>
					</tr>
					<tr>
						<td><label for='pwd'>Password</label></td>
						<td><input id='pwd' name='pwd' type='password' /></td>
					</tr>
					<tr>
						<td><label for='conpwd'>Confirm password</label></td>
						<td><input id='conpwd' name='conpwd' type='password' /></td>
					</tr>
					<tr>
						<td><label for='phone'>Phone</label></td>
						<td><input id='phone' name='phone' /></td>
					</tr>
					<tr>
						<td><label for=''>Gender</label></td>
						<td><input id='gender1' name='gender' type='radio' value='M' /><label for='gender1'> Male</label> <input id='gender2' name='gender' type='radio' value='F' /><label for='gender2'> Female</label></td>
					</tr>
					<tr>
						<td><input id='submit' name='submit' type='submit' value='Submit' /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>