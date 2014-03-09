<?php
	session_start();
	require_once("connection.php");
	if(isset($_POST['action']) && $_POST['action'] == 'show_exam')
	{
		if(!empty($_POST['st_id']))
		{
			$_SESSION['row_id'] = $_POST['st_id'];
		}
		else
		{
			$_SESSION['error']['show_exam'] = "Please select a student";
		}
	}
	if(isset($_POST['action']) && $_POST['action'] == 'record')
	{
		$_SESSION['row_id'] = $_POST['stud_id'];
		foreach ($_POST as $key => $value) 
		{
			if(empty($value))
			{
				$_SESSION['error'][$key] = $key . ' cannot be blank!';
			}
		}
		if(!isset($_SESSION['error']) && isset($_SESSION['row_id']))
		{
			if($_POST['grad'] >= 75)
			{
				$status = 'Passed';
			}
			else
			{
				$status = 'Failed';	
			}
			$rid = $_SESSION['row_id'];
			$query = "INSERT INTO exams (subject, grade, note, status, students_id, created_at, updated_at)
					  VALUES ('".$_POST['subj']."', '".$_POST['grad']."', '".$_POST['note']."', '".$status."', ".$rid.",NOW(),NOW())";
			mysqli_query($connection, $query);
		}
	}
	
header('Location: index.php');

?>