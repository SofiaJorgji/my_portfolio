<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/portfolio/MVC-CodeIgniter/friendfinder/assets/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/portfolio/MVC-CodeIgniter/friendfinder/assets/css/style.css" />
	<title>Login-Registration</title>
</head>
<body>
<div id="wrapper">
<?php 
	
	if(isset($submitted_form) && $submitted_form == 'login' && isset($error_message))
	{
		echo "<div class='container'><div class='alert-error'><p>". $error_message ."</p></div></div>";
	}
?>

	<div class="container">
		<h4>Log In</h4>
		<form action="" method="post" class="form-horizontal">		
			<div class="control-group">
				<label for="email" class="span1" >Email: </label>
				<div class="controls">
					<input type="text" id="email" class="span3" name="email" />
				</div>
			</div>
			<div class="control-group">
				<label for="password" class="span1">Password: </label>
				<div class="controls">
					<input type="password" id="password" name="password" />
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<input type="hidden" name="form_action" value="login" />
					<button type="submit" class="btn btn-primary pull-right">Login</button>
				</div>
			</div>
		</form>
	</div>
</div>
</body>
</html>