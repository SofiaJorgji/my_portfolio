<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css" />
	<title>Welcome</title>
</head>
<body>

<div id="wrapper">
	<div id="header">
		<h4>
			Welcome <?= $user['first_name']. '!' ?>
			<a href="<?= base_url('/login/logout') ?>" class="close">Log off!</a>
		</h4>
	</div>
	<div class="container indent_left_2">
		<!-- <fieldset>
		    <legend>User Infromation:</legend> -->
		   <!--  <p>First Name: <?= $user['first_name']?></p>
			<p>Last Name:  <?= $user['last_name']?></p> -->
			<p>Email Address: <?= $user['email']?></p>
		<!-- </fieldset>	 -->
	</div>
	<div class="list_of_friends">
		<table border="1" class="table table-striped">
			<thead>
				<th>Name</th>
				<th>Email</th>
			</thead>
			<tbody>
				<?php
				foreach ($users as $value) 
				{  
					// var_dump($value);
				if($value[1])
					{ ?>
					<tr>
						<td><?=$value[0]->first_name; ?></td>
						<td><?=$value[0]->email; ?></td>					
					</tr>	
			<?php   }
				} ?>
			</tbody>
		</table><br>
	</div>
	<div class="list_of_users">
		<table border="1" class="table table-striped">
			<thead>
				<th>Name</th>
				<th>Email</th>
				<th>Action</th>
			</thead>
			<tbody>
				<?php
				foreach ($users as $value) 
				{   ?>
					<tr>
						<td><?=$value[0]->first_name; ?></td>
						<td><?=$value[0]->email; ?></td>
						<?php 
						if($value[1])
						{ ?>
							<td><p>Friends</p></td>
				<?php   }
						else
						{?>
							<td>
								<form action="" method="post">
									<input type="hidden" name="action" value="add_friend">
									<input type="hidden" name="friend_id" value="<?=$value[0]->id; ?>">
									<input type="submit" value="Add as friend">
								</form>
							</td>
				<?php	}
						?>						
					</tr>						
				<?php 
			} ?>
			</tbody>
		</table><br>
	</div>
</div>

</body>
</html>