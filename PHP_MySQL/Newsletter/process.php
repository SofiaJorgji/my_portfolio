<?php
	session_start();
	include_once("connection.php");

	function register($connection, $post)
	{
		foreach ($post as $name => $value) 
		{
			if(empty($value))
			{
				$_SESSION['error'][$name] = "sorry, " . $name . " cannot be blank";
			}
			else
			{
				switch ($name) {
					case 'first_name':
					case 'last_name':
						if(is_numeric($value))
							$_SESSION['error'][$name] = $name . ' cannot contain numbers';
					break;
					case 'email':
						if(!filter_var($value, FILTER_VALIDATE_EMAIL))
							$_SESSION['error'][$name] = $name . ' is not a valid email';
					break;
				}
			}	
		}
		if($_FILES['file']['error'] > 0)
		{
			$_SESSION['error']['file'] = "Error on file upload Return Code: ".$_FILES['file']['error'];
		}
		else
		{
			$directory = 'upload/';
			$file_name = $_FILES['file']['name'];
			$file_path = $directory.$file_name;
			if(file_exists($file_path))
			{
				$_SESSION['error']['file'] = $file_name.' already exists'; 
			}
			else
			{
				if(!move_uploaded_file($_FILES['file']['tmp_name'], $file_path))
					$_SESSION['error']['file'] = $file_name." could not be saved";
			}
		}
		
		if(!isset($_SESSION['error']))
		{
			$query_students = "INSERT INTO students (first_name, last_name, email, pic_url, created_at)
							   VALUES('".$post['first_name']."', '".$post['last_name']."', '".$post['email']."', '".$file_path."', NOW())";
			$student_result = mysqli_query($connection, $query_students);		
			if($student_result)
			{
				$student_id = mysqli_insert_id($connection);
				if($student_id)
				{
					foreach ($_POST['rows'] as $row) 
					{
						$query_topic = "INSERT INTO students_has_topics(topics_id, students_id)
										VALUES($row, $student_id)";
						$topic_results = mysqli_query($connection, $query_topic);										
						if($topic_results)
						{
							$_SESSION['success_message'] = "Congratulations you are now a member!";
						}
					}
				}
			}
		}
	}	

	if(isset($_POST['action']) && $_POST['action'] == 'register')
		register($connection, $_POST);

header('Location: index.php');

?>