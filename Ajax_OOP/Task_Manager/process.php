<?php
	require_once('connection.php');

	if(isset($_POST['create_task']))
	{
		if(empty($_POST['task_name']))
		{
			$data['status'] = false;
			$data['message'] = 'Please enter...a task!';
		}
		else
		{
			$query = "INSERT INTO tasks (name, created_at, updated_at)
					 VALUES('". $_POST['task_name'] ."', NOW(), NOW())";
			$query_task = mysqli_query($connection, $query);

			if($query_task)
			{
				$data['status'] = true;
				$task_id = mysqli_insert_id($connection);
				$data['task'] = '<div>
									<button class="edit_task">Edit</button>
									<input id="checkbox" type="checkbox" name="tasks[]">
									<input type="hidden" name="task_id" value="'. $task_id .'">
									<input type="hidden" name="edit_task">
									<span>'. $_POST['task_name'] .'</span>
								</div>';
			}
			else
			{
				$data['status'] = false;
				$data['message'] = 'Check your query..';
			}
		}
	}

	if(isset($_POST['edit_task']))
	{		
		if(isset($_POST['tasks']))
		{
			foreach($_POST['tasks'] as $task => $value)
			{
				$query = "UPDATE tasks SET name = '". $value ."', updated_at = NOW()
							WHERE id = '". $task ."'";
				$query_update = mysqli_query($connection, $query);
				if($query_update)
				{
					$data['tasks'][$task] = $value;
					$data['status'] = true;
				}
			}
		}
	}
	echo json_encode($data);
?>