<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css" />
	<title>Courses</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script>
		$(document).ready(function() 
		{
			$('html').on("click",'a.edit_form',function(){
				var link=$(this);
				var form=$(this).closest('form');
				var mytd=link.parent();
				var name1=mytd.siblings('.name1').children('p');
				var nam=name1.html();
				name1.replaceWith( "<textarea name='course_name'>"+nam+"</textarea>" );
				var desc1=mytd.siblings('.desc1').children('p');
				var des=desc1.html();
				desc1.replaceWith( "<textarea name='description'>"+des+"</textarea>" );
				link.replaceWith("<a href='#' class='save_edit'>Save</a>");
			});
			$('html').on("click",'a.save_edit',function(){
				var form=$(this).closest('form');
				form.submit();
			});			
		});
	</script>	
</head>
<body>
<div id="wrapper">
	<div class="container">
		<div id="select_course">	
			<h3>Add a new course</h3>
			<form action="" method="post">
				<input type="hidden" name="action" value="add_course">
				Name: <input type="text" name="course_name"><br>
				Description: <textarea name="description"></textarea><br>
				<input type="submit" value="Add">	
			</form>
		</div>
		<?php
			if(empty($error))  
			{	 ?>
				<table border="1" class="table table-striped">
					<thead>
						<th>Course Name</th>
						<th>Description</th>
						<th>Date Added</th>
						<th>Actions </th>
					</thead>
					<tbody>
						<?php
						foreach ($records as $object) 
						{   ?>
							<tr>
								<form id="a" action="" method="post">
									<td class="name1"><p><?=$object->name; ?></p></td>
									<td class="desc1"><p><?=$object->description; ?></p></td>
									<td><?=$object->created_at; ?></td>
									<td class="edit_rec">
										<a href="#" class="edit_form">Edit</a>
					    			</td>
					    			<input type="hidden" name="edit_form" value="edit">
					    			<input type="hidden" name="update_rec" value="<?= $object->id ;?>"/>
								</form>
								<td class="remove">
									<form id="b<?= $object->id ; ?>" action="" method="post">
										<input type="hidden" name="delete_form" value="remove">
				    					<a href="#" onclick="document.getElementById('b<?= $object->id ; ?>').submit();">Remove</a>
				    					<input type="hidden" name="remove_rec" value="<?= $object->id ;?>"/>
									</form>
								</td>	
							</tr>								
						<?php } ?>
					</tbody>
				</table><br>
				<?php
			} ?>	
	</div>
</div>
</body>
</html>