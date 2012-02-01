<html>
<head><title>Casimira Login</title>
</head>
<body>
<?php echo mt_rand();

?>
	<form method="POST" action="/login/submit">
		<div>
			<label>Email</label><input type='text' name='email' />
		</div>
		<div>
			<label>Password</label><input type='password' name='pwd' />
		</div>
		<div><a href=''>forgotten password?</a></div>
		<div><a href=''>Registration</a></div>
		<div><input type='submit' value='Submit' /><input type='button' value='Reset' />
	</form>
</body>
</html>