<?php
	session_start();
	include_once("connection.php");
?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Newsletter</title>
		<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" />
		<style>
			#first_name{
				margin-left: 35px;
				margin-bottom: 20px;
			}
			#last_name{
				margin-left: 37px;
				margin-bottom: 20px;
			}
			#email{
				margin-left: 70px;
				margin-bottom: 20px;
			}
			#register{
				margin-top: 30px;
				margin-left: 130px;
			}
			#file{
				margin-bottom: 20px;
			}
			#checkbox{
				width: 150px;
				border: 2px solid;
				padding: 5px;
			}
			img{
				width: 150px;
				height: 150px;
				margin: 10px;
			}
			.element_inline{
				height:auto;
				width:auto;
				padding:10px;
				margin:10px;
				border:1px solid grey;
			}
			.left{
				float:left;
			}
			.clear{
				clear:both;
			}
			.topics{
				height:auto;
				width:auto;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<?php

			if(isset($_SESSION['error']))
			{
				foreach ($_SESSION['error'] as $key => $value) 
				{
					echo $value.'<br>';		
				}
			}
			echo (isset($_SESSION['success_message']) ? $_SESSION['success_message'] : "");
			?>		
			<h1>Register for our Newsletter!</h1>
			<form action="process.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="register">
				<label for="first_name">First Name </label>
				<input id="first_name" name="first_name" type="text"><br>
				<label for="last_name">Last Name </label>
				<input id="last_name" name="last_name" type="text"><br>
				<label for="email">Email </label>
				<input id="email" name="email" type="text"><br>
				<label for="file">Upload Picture </label>
				<input id="file" type="file" name="file"><br>	
				<input id="register" type="submit" value="Register">

			<h3>What Topics are you interested in hearing about?</h3>
			<div id="checkbox">
				<?php
					$query = "SELECT * FROM topics";
					$rows = fetchAll($connection, $query);
					foreach ($rows as $row)
						echo "<input type='checkbox' name='rows[]' value='".$row['id']."'>" . $row['name'] . "<br>";
				?>
			</div>
			</form>
			<div id="row">
				<h2>See what other students are interested in!</h2>
				<?php
				foreach ($rows as $row) 
				{
					echo "<div class='well'>";
						$query_students = "SELECT topics.name, students.id, students.first_name, students.last_name, students.email, students.pic_url
										   FROM students
										   LEFT JOIN students_has_topics ON students.id = students_has_topics.students_id
										   LEFT JOIN topics ON students_has_topics.topics_id = topics.id
										   WHERE students_has_topics.topics_id =" . $row['id'];
										   
						$student_profiles = fetchAll($connection, $query_students);
						echo '<h3>'.$row['name'] . '</h3>';

						foreach ($student_profiles as $profile) 
						{	?>
							<div class="element_inline left">
								<img src="<?= $profile['pic_url'] ?>" >
								<p><?= $profile['first_name'] . " " . $profile['last_name'] ?></p>
								<p><?= $profile['email'] ?></p>
							</div>
	<?php				}	?>
							<div class='clearfix'></div>
					</div>
<?php			} ?>
			</div>
		</div>
	</body>
</html>

<?php
session_destroy();
?>