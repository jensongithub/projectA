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
			<?php if( $this->input->post('submit') ) echo "<div class='error-panel'>"; ?>			
				<?php echo validation_errors(); ?>
			<?php if( $this->input->post('submit') ) echo "</div>"; ?>
			<?php 
				$attr = array('class' => 'form', 'id' => 'registration-form');
				echo form_open('register', $attr);
			?>
				<table>
					<tr>
						<td><label for='email' class='form-label'><?php echo lang('email'); ?></label></td>
						<td><input id='email' name='email' type='email' value='<?php echo set_value('email'); ?>' /></td>
					</tr>
					<tr>
						<td><label for='firstname' class='form-label'><?php echo lang('firstname'); ?></label></td>
						<td><input id='firstname' name='firstname' value='<?php echo set_value('firstname'); ?>' /></td>
					</tr>
					<tr>
						<td><label for='lastname' class='form-label'><?php echo lang('lastname'); ?></label></td>
						<td><input id='lastname' name='lastname' value='<?php echo set_value('lastname'); ?>' /></td>
					</tr>
					<tr>
						<td><label for='pwd' class='form-label'><?php echo lang('pwd'); ?></label></td>
						<td><input id='pwd' name='pwd' type='password' value='<?php echo set_value('pwd'); ?>' /></td>
					</tr>
					<tr>
						<td><label for='conpwd' class='form-label'><?php echo lang('conpwd'); ?></label></td>
						<td><input id='conpwd' name='conpwd' type='password' value='<?php echo set_value('conpwd'); ?>' /></td>
					</tr>
					<tr>
						<td><label for='phone' class='form-label'><?php echo lang('phone'); ?></label></td>
						<td><input id='phone' name='phone' value='<?php echo set_value('phone'); ?>' /></td>
					</tr>
					<tr>
						<td><label for='' class='form-label'><?php echo lang('gender'); ?></label></td>
						<td><input id='gender1' name='gender' type='radio' value='M' <?php echo set_radio('gender', 'M'); ?> /><label for='gender1'> <?php echo lang('male', 'gender1'); ?></label> <input id='gender2' name='gender' type='radio' value='F' <?php echo set_radio('gender', 'F'); ?> /><label for='gender2'> <?php echo lang('female'); ?></label></td>
					</tr>
					<tr>
						<td><input id='submit' name='submit' type='submit' value='<?php echo lang('submit'); ?>' /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>