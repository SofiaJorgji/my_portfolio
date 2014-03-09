<?php
	require_once("connection.php");

	// Process creation of note
	if(isset($_POST['title'])) 
	{
		if($_POST['title'] != NULL)
		{
			$query = "INSERT INTO posts (title, created_at)
						VALUES('". mysqli_real_escape_string($connection, $_POST['title']) ."', NOW())";

			$result = mysqli_query($connection, $query);

			if(mysqli_affected_rows($connection) > 0)			
			{
				$data['status'] = TRUE;
				$data['note'] = '<div class="row-fluid">
									<div class="offset3 span6 offset3 well">
										<h3 class="pull-left">'. $_POST['title'] .'</h3>
										<form class="delete_note" action="process.php" method="post">
											<button class="btn btn-link pull-right">delete</button>
											<input type="hidden" name="action" value="delete">
											<input type="hidden" name="note_id" value="'. mysqli_insert_id($connection) .'">
										</form>
										<div class="clearfix"></div>
										<form action="process.php" method="post" class="edit_note form-horizontal">
											<div class="note_description">
												<div class="control-group">
													<textarea name="description" placeholder="Please enter your description..."></textarea>
												</div>
												<input type="submit" value="Save" class="btn btn-success btn-mini">
											</div>
											<input type="hidden" name="note_id" value="'. mysqli_insert_id($connection) .'">
										</form>
									</div>
								</div>';
			}
			else
			{
				$data['status'] = FALSE;
				$data['message'] = 'Something went wrong while adding your note.';
			}
		}
	}

	// Process edit note
	if(isset($_POST['description']))
	{
		$data['note'] = '<div class="note_description">
							<p>'. $_POST['description'] .'</p>
						</div>';

		$query = "UPDATE posts SET description = '". $_POST['description'] ."', updated_at = NOW()
					WHERE id = '". $_POST['note_id'] ."'";

		$result = mysqli_query($connection, $query);

		if(mysqli_affected_rows($connection) > 0)
		{	
			$data['status'] = TRUE;
			
			if($_POST['description'] == NULL OR $_POST['description'] == "")
			{
				$data['description_is_empty'] = TRUE;
			}
		}
		else
		{
			$data['status'] = FALSE;
			$data['message'] = 'Something went wrong with your query.';
		}
	}

	if(isset($_POST['action']) && $_POST['action'] == 'delete')
	{
		$query = "DELETE FROM posts
				  WHERE id = '". $_POST['note_id'] ."'";

		mysqli_query($connection, $query);

		if(mysqli_affected_rows($connection) > 0)
		{
			$data['status'] = TRUE;
		}
		else
		{
			$data['status'] = FALSE;
			$data['message'] = 'Something went wrong while deleting your note.';
		}
	}

	echo json_encode($data);
?>