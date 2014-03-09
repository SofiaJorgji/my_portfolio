<?php
	require_once('connection.php');
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Task Manager</title>
		<link rel="stylesheet" href="style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script>
			$(document).ready(function() 
			{
				$("#create_task").submit(function()
				{
					var form = $(this);
					$.post(form.attr("action"), 
						form.serialize(), 
						function(data)
						{
							if(data.status)
							{
								$("#edit_form").find("fieldset").append($(data.task));
							}
							else
							{
								alert(data.message);
							}
						}, "json");
						return false;
				});

				$("html").on("click", "button.edit_task", function()
				{
					var button = $(this);
					var form = $("#edit_form");
					var task_name = button.siblings("span").text();	
					var task_checkbox = button.siblings(".box");
					var task_id = button.siblings(".taask_id").val();

					if(button.siblings("span").is(":visible"))
					{
						button.siblings("span").replaceWith("<input id='taskSpan' type='text' name='tasks["+ task_id +"]' value='"+ task_name +"'>");
					}
					else
					{
						$.post(form.attr("action"),
							form.serialize(), 
							function(data)
							{
								if(data.status)
								{
									$('#taskSpan').replaceWith("<span>"+ data.tasks[task_id] +"</span>");
								}
							}, "json");
					}	
					return false;
				});

				$("html").on('click', '.box', function()
				{
					var checkbox = $(this);
					$tag = checkbox.prop('checked');
					if($tag)
					{
						checkbox.siblings("span").addClass("grey");
					}
					else
					{
						checkbox.siblings("span").removeClass("grey");
					}
				});
			});
		</script>
	</head>
	<body>
		<div id="container">
			<form id="edit_form" action="process.php" method="post">
				<fieldset>
					<legend><h2>List of Tasks</h2></legend>
	<?php 				$query = "SELECT * FROM tasks";
						$tasks = fetch_all($connection, $query);
						if($tasks)
						{
							foreach($tasks as $task)
							{	?>
								<div>
									<button class="edit_task">Edit</button>
									<input id="checkbox" type="checkbox" name="tasks[]" class="box">
									<input type="hidden" class="taask_id" name="task_id" value="<?=$task['id']; ?>">
									<span><?=$task['name']; ?></span>
								</div>
				<?php		}
						}	?>
						<input type="hidden" name="edit_task">
				</fieldset>
			</form>
			<form action="process.php" id="create_task" method="post">
				<fieldset>
					<legend><h2> Create a new task: </h2></legend>
						<textarea name="task_name" id="task_description" rows="3"></textarea>
						<input type="hidden" name="create_task">
						<input id="button1" type="submit" value="Create Task">
				</fieldset>
			</form>
		</div>
	</body>
</html>