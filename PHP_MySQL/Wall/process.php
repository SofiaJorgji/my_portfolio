<?php
	session_start();
	require_once('connection.php');

	if(isset($_POST['action']) && $_POST['action'] == "register")
		register_action($connection, $_POST);
	if(isset($_POST['action']) && $_POST['action'] == "login")
		login_action($connection, $_POST);
	if(isset($_POST['action']) && $_POST['action'] == "logout")
		logout();
	if(isset($_POST['action']) && $_POST['action'] == "post")
		message_action($connection, $_POST);
	if(isset($_POST['action']) && $_POST['action'] == "comment")
		comment_action($connection, $_POST);

	function register_action($connection, $post)
	{
		if(empty($_POST['first_name']))
			$_SESSION['errors'][] = "First Name field is required";
		if(empty($_POST['last_name']))
			$_SESSION['errors'][] = "Last Name field is required";
		if(empty($_POST['email']))
			$_SESSION['errors'][] = "Email field is required";
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			$_SESSION['errors'][] = "Invalid Email";
		if(empty($_POST['password']))
			$_SESSION['errors'][] = "Password Field is required";
		if(empty($_POST['confirm_password']))
			$_SESSION['errors'][] = "Confirm Password Field is required";
		if($_POST['password'] != $_POST['confirm_password'])
			$_SESSION['errors'][] = "Passwords do not match!";

		if(empty($_SESSION['errors']))
		{
			$check_email_query = "SELECT * FROM users WHERE email = '". $_POST['email'] ."' ";
			$check_email = fetch_record($connection, $check_email_query);
			if(!$check_email)
			{
				$password = md5($_POST['password']);
				$insert_user_query = "INSERT INTO users (first_name, last_name, email, password, created_at) 
									  VALUES ('". $_POST['first_name'] ."', '". $_POST['last_name'] ."', '". $_POST['email'] ."', '". $password ."', NOW()) ";
				$insert_user_result = mysqli_query($connection, $insert_user_query);

				if($insert_user_result)
				{
					$user = array(
						"id" => mysqli_insert_id($connection),
						"first_name" => $_POST['first_name'],
						"last_name" => $_POST['last_name'],
						"email" => $_POST['email'],
						"logged_in" => TRUE
					);
					$_SESSION['user'] = $user;
					header('Location: wall.php');
				}
				else
				{
					$_SESSION['errors'][] = "Something went wrong. Please check database connection.";
					header('Location: index.php');					
				}
			}
			else
			{
				$_SESSION['errors'][] = "Email address already exists!";
				header('Location: index.php');				
			}
		}
		else
			header('Location: index.php');

		exit();
	}

	function login_action($connection, $post)
	{
		if(empty($_POST['email']))
			$_SESSION['errors'][] = "Email field is required";
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			$_SESSION['errors'][] = "Invalid Email";
		if(empty($_POST['password']))
			$_SESSION['errors'][] = "Password Field is requried";
		if(empty($_SESSION['errors']))
		{
			$check_user = "SELECT * FROM users WHERE email = '". $_POST['email'] ."' AND password = '". md5($_POST['password']) . "' ";
			$user = fetch_record($connection, $check_user);			
			if($user == false)
			{
				$_SESSION['errors'][] = "Invalid email and password combination.";
				header('Location: index.php');
			}
			else
			{
				$user += array(
					"logged_in" => TRUE
				);
				$_SESSION['user'] = $user;
				header('Location: wall.php');		
			}
		}
		else
			header('Location: index.php');
		exit();
	}

	function logout()
	{
		session_destroy();
		header('Location: index.php');
		exit();
	}

	function message_action($connection, $post)
	{
		if(!empty($_POST['post']))
		{
			$insert_post_query = "INSERT INTO posts (user_id, content, created_at) 
								  VALUES ('". $_SESSION['user']['id'] ."', '". $_POST['post'] ."', NOW()) ";
			$insert_post = mysqli_query($connection, $insert_post_query);

			if($insert_post == TRUE)
				$_SESSION['notifications'][] = "New message inserted!";
			else
				$_SESSION['errors'][] = "Cannot post message right now. Please check database connection.";
		}
		else
			$_SESSION['errors'][] = "message field must not be empty!";

		header('Location: wall.php');
		exit();
	}

	function comment_action($connection, $post)
	{
		if(!empty($_POST['comment']))
		{
			$insert_comment_query = "INSERT INTO comments (user_id, post_id, content, created_at) 
									 VALUES('". $_SESSION['user']['id'] ."', '". $_POST['message_id'] ."', '". $_POST['comment'] ."', NOW()) ";
			$insert_comment = mysqli_query($connection, $insert_comment_query);

			if($insert_comment == TRUE)
			{
				$_SESSION['notifications'][] = "New comment inserted";
			}
			else
				$_SESSION['errors'][] = "Cannot comment right now. Please check database connection.";
		}
		else
			$_SESSION['errors'][] = "Comment field must not be empty!";

		header('Location: wall.php');
		exit();
	}
?>