<?php
	require_once('connection.php');
	require("catalog.php");
	$cat = new Catalog();

	if(isset($_POST['action']) && $_POST['action'] = "add_prod")
	{
		if(empty($_POST['product_name']) || empty($_POST['prod_desc']))
		{
			$data['status'] = false;
			$data['message'] = "Please enter all the fields!";
		}	
		else
		{
			$prod_id = $cat->add_prod($_POST['product_name'], $_POST['prod_desc'], $_POST['category_id']);
			$cat_name = $cat->get_cat($_POST['category_id']);
			if($prod_id > 0)
			{
				$data['status'] = true;
				$data['output'] = "<tr class='deleting'>
								<td>".$_POST['product_name']."</td>
								<td>".$cat_name[0]['category_name']."</td>
								<td>".$_POST['prod_desc']."</td>
								<td class='del'> <form class='delete_prod' action='process.php' method='post'>
										<a href='#' class='delete_button'> delete </a>
										<input type='hidden' name='delete_prod' value='".$prod_id."'>
									</form></td>
							</tr>";
			}
			else
			{
				$data['status'] = false;
				$data['message'] = "Check your Database!";	
			}
		}
		echo json_encode($data);
	}

	if(isset($_POST['delete_prod']))
	{
		$data['status']=true;
		$result = $cat->delete_prod($_POST['delete_prod']);
		echo json_encode($data);
	}
?>