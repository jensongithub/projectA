<html>
<head><title>Casimira Login</title>
</head>
<body>
<?php //echo mt_rand();?>
	<form method="POST" action="login/submit">
		<div>
			<label><?php echo _('Email:');?></label><input type='text' name='email' />
		</div>
		<div>
			<label><?php echo _('Password:');?></label><input type='password' name='pwd' />
		</div>
		<div><a href=''><?php echo _('Fogotten Password:');?></a></div>
		<div><a href=''><?php echo _('Registration:');?></a></div>
		<div><input type='submit' value='<?php echo _('Login:');?>' /><input type='button' value='Reset' />
	</form>
</body>
</html>