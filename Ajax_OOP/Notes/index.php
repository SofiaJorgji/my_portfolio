<?php
	require_once('connection.php');
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Notes</title>
		<link rel="stylesheet" href="http://bootswatch.com/cosmo/bootstrap.min.css">
		<link rel="stylesheet" href="style.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script>
			$(document).ready(function()
			{
				$("#add_note").on("submit", function()
				{
					var form = $(this);
					$.post(form.attr("action"), 
						form.serialize(), 
						function(data)
						{
							if(data.status)
							{
								$(data.note).appendTo("#notes").fadeIn();
								form.find(".note_description").html(data.note);
							}
							else
							{
								alert(data.message);
							}
						}, "json");
					return false;
				});

				$("#notes").on("submit", "form.edit_note", function()
				{
					var form = $(this);
					$.post(form.attr("action"), 
						form.serialize(), 
						function(data)
						{
							if(data.status)
							{
								if(!data.description_is_empty)
								{
									form.find(".note_description").html(data.note);
								}
							}
							else
							{
								alert(data.message);
							}
						}, "json");
					return false;
				});

				$("#notes").on("click", ".note_description p", function(event)
				{
					var form = $(this).closest("form");
					var note_id = form.find("input[name='note_id']").val();
					var edit_form = "<div class='control-group'>\n"+
										"<textarea name='description' placeholder='Please enter your description...'>"+ form.find(".note_description p").text() +"</textarea>\n"+
									"</div>\n"+
									"<input type='submit' value='Save' class='btn btn-success btn-mini'>";

					form.find(".note_description").html(edit_form);
					return false;
				});

				$("#notes").on("click", ".delete_note button", function()
				{
					var form = $(this).closest('form');
					
					if(confirm("Are you sure you want to delete this note?"))
					{
						$.post(form.attr("action"), form.serialize(), function(data)
						{
							if(data.status)
							{
								form.closest(".row-fluid").fadeOut();
							}
							else
							{
								alert(data.message);
							}
						}, "json");
					}
					return false;
				});
			});
		</script>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span12">
					<div class="well">
						<h1>Notes</h1>
					</div>
				</div>
			</div>
			<div id="notes">
			<?php	
			$query = "SELECT * FROM posts";
			$notes = fetch_all($connection, $query);

			if($notes)
			{
				foreach($notes as $note)
				{	?>
					<div class="row-fluid">
						<div class="offset3 span6 offset3 well">
							<h3 class="pull-left"><?=$note['title']; ?></h3>
							<form class="delete_note" action="process.php" method="post">
								<button class="btn btn-link pull-right">delete</button>
								<input type="hidden" name="action" value="delete">
								<input type="hidden" name="note_id" value="<?=$note['id']; ?>">
							</form>
							<div class="clearfix"></div>
							<form action="process.php" method="post" class="edit_note form-horizontal">
	<?php 					if($note['description'] != NULL)
							{	?>
								<div class="note_description">
									<p><?=$note['description']; ?></p>
								</div>
								<input type="hidden" name="note_id" value="<?=$note['id']; ?>">
	<?php 					}
							else
							{	?>
								<div class="control-group">
									<div class="note_description">
										<textarea name="description" placeholder="Please enter your description..."></textarea>
									</div>
								</div>
								<input type="hidden" name="note_id" value="<?=$note['id']; ?>">
								<input type="submit" value="Save" class="btn btn-success btn-mini">
	<?php 					}	?>						
							</form>
						</div>
					</div>
	<?php 		}
			}	?>
			</div>
			<div class="row-fluid">
				<div class="offset3 span6 offset3">
					<form id="add_note" action="process.php" method="post" class="form-horizontal">
						<div class="control-group">
							<input type="text" name="title">
						</div>
						<input type="submit" value="Add note" class="btn btn-primary">
					</form>
				</div>
			</div>
		</div>
	</body>
</html>