<?php 
	session_start(); 

	if(isset($_SESSION['user']) AND $_SESSION['user']['logged_in'] == TRUE)
		header('Location: wall.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>The Wall</title>
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" />
</head>
<body>
<?php
	if(isset($_SESSION['errors']))
	{
		foreach($_SESSION['errors'] as $error)
		{
			echo $error . "<br>";
		}
	}
?>
	<div class="container">
		<div class="row-fluid">
			<div class="span6">
				<h1>Register</h1>
				<form action="process.php" method="post" class="form-horizontal">
					<div class="control-group">
						<label for="first_name" class="control-label">First Name:</label>
						<div class="controls">
							<input type="text" name="first_name" id="first_name" />
						</div>						
					</div>
					<div class="control-group">
						<label for="last_name" class="control-label">Last Name:</label>
						<div class="controls">
							<input type="text" name="last_name" id="last_name" />
						</div>
					</div>
					<div class="control-group">
						<label for="email"  class="control-label">Email:</label>
						<div class="controls">
							<input type="email" name="email" id="email" />
						</div>
					</div>
					<div class="control-group">
						<label for="password" class="control-label">Password:</label>
						<div class="controls">
							<input type="password" name="password" id="password" />
						</div>
					</div>
					<div class="control-group">
						<label for="confirm_password"  class="control-label">Confirm Password:</label>
						<div class="controls">
							<input type="password" name="confirm_password" id="confirm_password" />
						</div>
					</div>
					<input type="hidden" name="action" value="register" />
					<input type="submit" value="Register"  class="btn btn-success"/>
				</form>
			</div>
			<div class="span6">
				<h1>Login</h1>
				<form action="process.php" method="post" class="form-horizontal">
					<div class="control-group">
						<label for="email" class="control-label">Email</label>
						<div class="controls">
							<input type="email" name="email" id="email" />
						</div>
					</div>
					<div class="control-group">
						<label for="password"  class="control-label">Password</label>
						<div class="controls">
							<input type="password" name="password" id="password" />
						</div>
					</div>
					<input type="hidden" name="action" value="login" />
					<input type="submit" value="Login" class="btn btn-success"/>
				</form>
			</div>
		</div>
	</div>
<?php $_SESSION['errors'] = array(); ?>
</body>
</html>