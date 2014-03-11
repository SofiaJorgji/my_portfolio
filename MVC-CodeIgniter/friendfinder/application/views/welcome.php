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
	<a href="<?= base_url('/login/logout') ?>" class="close">Logout</a>
	<h3> Welcome <?= $user['first_name']. '!' ?></h3>
	<h4> You have <a href="<?= base_url('/login/friends_page') ?>"><?= $nfriends; ?> friends</a></h4>
	<div class="notifications">
		<h3>Notifications:</h3>
		<table border="1" class="table table-striped">
			<tbody>
				<?php
				foreach ($notes as $object) 
				{  
					?>
						<tr>
							<td><?=$object->first_name.' '.$object->last_name.' wants to be your friend'; ?></td>
							<td>
								<form id="b<?= $object->id ; ?>" action="" method="post">
									<input type="hidden" name="accept_form" value="accept">
			    					<a href="#" onclick="document.getElementById('b<?= $object->id ; ?>').submit();">Accept</a>
			    					<input type="hidden" name="new_fr_id" value="<?= $object->id ;?>"/>
								</form>
							</td>
							<td>
								<form id="a<?= $object->id ; ?>" action="" method="post">
									<input type="hidden" name="ignore_form" value="ignore">
			    					<a href="#" onclick="document.getElementById('a<?= $object->id ; ?>').submit();">Ignore</a>
			    					<input type="hidden" name="ignore_id" value="<?= $object->id ;?>"/>
								</form>					
							</td>
						</tr>						
					<?php 
				} ?>
			</tbody>
		</table><br>
	</div>	
	<h3>People you may want to add as friends</h3>
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
				{  
					if($user['user_id'] !== $value[0]->id && $value[1] !== 1) 
					{?>
						<tr>
							<td><?=$value[0]->first_name; ?></td>
							<td><?=$value[0]->email; ?></td>
							<?php 
							if($value[1] === -1)
							{ ?>
								<td><p>Friend invite sent</p></td>
					<?php   }
							else if($value[1] === 0)
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
					}
				} ?>
			</tbody>
		</table><br>
	</div>
</div>

</body>
</html>