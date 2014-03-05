<?php 
	session_start();
	require_once("connection.php");

	if(!isset($_SESSION['user']) OR $_SESSION['user']['logged_in'] != TRUE)
	{
		header("Location: 404.php");
		die();
		$_SESSION = array();
	}

	$messages_query = "SELECT first_name, last_name, email, content, posts.created_at, posts.user_id as user_id, posts.id FROM posts 
					   LEFT JOIN users ON users.id = posts.user_id ORDER BY posts.created_at DESC";
	$messages = fetch_all($connection, $messages_query);

	$comments_query = "SELECT first_name, last_name, email, content, comments.created_at, comments.user_id as user_id, 
					   comments.id as comment_id, comments.post_id 
					   FROM comments 
					   LEFT JOIN users ON users.id = comments.user_id ORDER BY comments.created_at DESC";
	$comments = fetch_all($connection, $comments_query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>The Wall Page</title>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" />
</head>
<body>
	<div class="container">
		<form action="process.php" method="post">
			<input type="hidden" name="action" value="logout" />
			<input type="submit" value="Logout" />
		</form>
		<h2>Welcome, <?php echo $_SESSION['user']['first_name']; ?></h2> 
		<h3><?php echo $_SESSION['user']['email']; ?></h3>

		<form action="process.php" method="post">
			<input type="hidden" name="action" value="post" />
			<textarea name="post" id="post" cols="60" rows="5" placeholder="What is on your mind?"></textarea> <br />
			<input type="submit" value="Post" />
		</form>
	<?php 	if(isset($_SESSION['notifications']))
			{
				foreach($_SESSION['notifications'] as $notification)
				{
					echo "<p style='color: green;'> $notification </p>";
				}
			}
			
			if(isset($_SESSION['errors']))
			{
				foreach($_SESSION['errors'] as $error)
				{
					echo "<p style='color: red;'> $error </p>";
				}
			}
			$_SESSION['notifications'] = array();
			$_SESSION['errors'] = array();
	?>

	<?php 	if(isset($messages) && !empty($messages))
			{ ?>
				<ol>
	<?php		foreach($messages as $message)
				{ 
	?>
					<li><p><?php echo $message['content']; ?></p>
						<small>by <?php echo $message['first_name']; ?> | <?php echo $message['created_at']; ?></small> 
					<ul>					
	<?php			foreach($comments as $comment)
					{ 
						if($message['id'] == $comment['post_id'])
						{
	?>
						<li>
							<p><?php echo $comment['content']; ?></p>
							<small>by <?php echo $comment['first_name'] ?> | <?php echo $comment['created_at']; ?></small>
						</li>
	<?php 				}
					} ?>
						<li>
							<form action="process.php" method="post">
								<input type="hidden" name="action" value="comment" />
								<input type="hidden" name="message_id" value="<?php echo $message['id']; ?>" />
								<input type="text" name="comment" placeholder="comment..." />
								<button type="submit">Comment</button>
							</form>
						</li>
					</ul>
	<?php		} ?>
				</ol>
	<?php	} ?>
	</div>
</body>
</html>