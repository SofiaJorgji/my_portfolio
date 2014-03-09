<?php
	require_once('connection.php');
	require('catalog.php');
	$db = new Database();
	$cat = new Catalog();
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>New Products</title>
		<link rel="stylesheet" href="ajax.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script>
			$(document).ready(function() 
			{
				$('#products').on("submit", function(){
					var form = $(this);
					$.post(form.attr("action"), 
						form.serialize(), 
						function(data)
						{
							if(data.status)
							{
								$('tbody.list').append(data.output);
							}
							else
							{
								alert(data.message);
							}
						}, "json");					
					return false;
				});
				$('html').on("click",'a.delete_button',function(){
					var form = $(this).closest('form');
					$.post(form.attr("action"), 
						form.serialize(), 
						function(data)
						{
							if(data.status)
							{
								form.closest('.deleting').hide();
							}
							else
							{
								alert('Problem while deleting item');
							}
						}, "json");					
					return false;
				});
			});
		</script>
	</head>
	<body>
		<div id="container">
			<fieldset>
				<h1><u>Add New Product:</u></h1>
				<form id="products" action="process.php" method="post">
					<input type="hidden" name="action" value="add_prod"> 
					<label for="product_name">Product Name: </label>
					<input id="product_name" type="text" name="product_name"><br>
					<label id="category" for="category">Category: </label>
					<select class="categ" name="category_id">
						<?php
						$query = "SELECT * FROM categories";
						$result = $db->fetch_all($query);
						foreach($result as $category)
						{	?>
							<option value="<?=$category['id']; ?>"><?= $category['category_name'] ?></option>
						<?php
						} 	?>
					</select>
					<div>
						<label id="description">Description</label>
						<textarea name="prod_desc" rows="3"></textarea><br>
						<input id="add" type="submit" value="Add">
					</div>
				</form>
			</fieldset>	
			<fieldset>
				<table border="1" class="table table-striped">
					<thead>
						<th>Name</th>
						<th>Category</th>
						<th>Description</th>
						<th>Action</th>
					</thead>
					<tbody class="list">
						<?php
						$result1 = $cat->display_prod();
						if($result1)
						{
							foreach ($result1 as $row) 
							{ ?>
								<tr class='deleting'>
									<td><?=$row['prod_name']; ?></td>
									<td><?=$row['category_name']; ?></td>
									<td><?=$row['prod_description']; ?></td>
									<td class="del">
										<form class="delete_prod" action="process.php" method="post">
											<a href="" class="delete_button">delete</a>
											<input type="hidden" name="delete_prod" value="<?=$row['prod_id']; ?>">
										</form>
									</td>
								</tr>						
						<?php } }?>
					</tbody>
				</table><br>
			</fieldset>	
		</div>
	</body>
</html>