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
				var mytd=link.parent();
				var name1=mytd.siblings('.name1').children('p');
				var nam=name1.html();
				name1.replaceWith("<textarea class='course_name'>"+nam+"</textarea>");
				var desc1=mytd.siblings('.desc1').children('p');
				var des=desc1.html();
				desc1.replaceWith("<textarea class='description'>"+des+"</textarea>");
				link.replaceWith("<a href='#' class='save_edit'>Save</a>");
			});
			$('html').on("click",'a.save_edit',function(){
				var link=$(this);
				sib_form=link.siblings('form');
				var rec_id=sib_form.children('input').val();
				console.log(rec_id);
				var mytd=link.parent();
				var name1=mytd.siblings('.name1').children('textarea');
				var nam=name1.val();
				console.log(nam);
				var desc1=mytd.siblings('.desc1').children('textarea');
				var des=desc1.val();
				console.log(des);
				sib_form.append("<input type='hidden' name='update' value='submit'>");
				sib_form.append("<input type='hidden' name='course_name' value="+nam+">");
				sib_form.append("<input type='hidden' name='description' value="+des+">");
				sib_form.trigger('submit');
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
						<th>Action</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php
						foreach ($records as $object) 
						{   ?>
							<tr>
								<td class="name1"><p><?=$object->name; ?></p></td>
								<td class="desc1"><p><?=$object->description; ?></p></td>
								<td><?=$object->created_at; ?></td>
								<td class="edit_rec">
									<a href="#" class="edit_form">Edit</a>
									<form action='' method='post'>
										<input type="hidden" class="rec_id" name="rec_id" value="<?= $object->id ;?>">
									</form>
				    			</td>
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