<?php
	session_start();
	require_once("connection.php");
?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Teacher</title>
		<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" />
		<style>
		*{
		    margin:0px;
		    padding: 0px;
		    font-family: arial, sans-serif;
		}
		.container{
			margin: 10px auto;
			padding: 10px;
			width:950px;
			height:880px;
			margin: 0 auto;
			background-color:#999966;
		}
		#select_student{
			margin-bottom: 20px;
		}
		.grade{
			margin: 55px;
		}
		#record{
			margin-left: 330px;
			margin-top: 15px;
		}
		#subject{
			margin-left: 40px;
		}
		.select_student{
			margin-top: 10px;
		}
		select{
			width: 200px;
			height: 30px;
			background-color: #ccffff;
		}
		input{
			width: 300px;
			height: 50px;
			background-color: #993300;
			margin-left: 20px;
			padding: 5px;
		}
		#sel_student{
			font-size: 26px;
		}
		#submit{
			font-size: 26px;
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
						echo $_SESSION['error'][$key] . '<br>';
					}
				}
			?>	
			<div id="select_student">	
				<h1>Welcome, Teacher!</h1><br>
				<form action="process.php" method="post">
					<input type="hidden" name="action" value="show_exam">
					<div class="select_student">
						<label id="sel_student" for="full_name">Select Student: </label>
							<select name="st_id">
								<option value=""></option>
								<?php 
								$query = "SELECT id, CONCAT_WS(' ', first_name, last_name) AS full_name FROM students";
								$result = mysqli_query($connection, $query);
								while($row = mysqli_fetch_assoc($result))
								{ 
									if(isset($_SESSION['row_id']) && $_SESSION['row_id'] == $row['id'])
									{
										$tag = 'selected';
									}
									else
									{
										$tag = '';
									}?>
									<option value="<?=$row['id']; ?>" <?=$tag ?>><?=$row['full_name']; ?></option>
									<?php
								} ?>
							</select>
						<input id="submit" type="submit" value="Show Exam Record">
					</div>
				</form>
			</div>
			<?php
			if(isset($_SESSION['row_id']))
			{
				$rid = $_SESSION['row_id'];
				$query1 = "SELECT exams.id AS eid, exams.subject AS subject, exams.note AS note, 
						   exams.status AS status, exams.grade AS grade
					       FROM exams
						   JOIN students ON exams.students_id = students.id
						   WHERE students.id = $rid"; 
				$result1 = mysqli_query($connection, $query1); ?>
				<table border="1" class="table table-striped">
					<thead>
						<th>Exam ID</th>
						<th>Subject</th>
						<th>Grade</th>
						<th>Status</th>
						<th>Notes</th>
					</thead>
					<tbody>
						<?php
						while($row = mysqli_fetch_assoc($result1))
						{ ?>
							<tr>
								<td><?=$row['eid']; ?></td>
								<td><?=$row['subject']; ?></td>
								<td><?=$row['grade']; ?></td>
								<td><?=$row['status']; ?></td>
								<td><?=$row['note']; ?></td>
							</tr>							
						<?php } ?>
					</tbody>
				</table><br>
				<div>
					<p>Add Record: </p>
					<form action="process.php" method="post">
						<input type="hidden" name="action" value="record">
						<input type="hidden" name="stud_id" value="<?=$rid; ?>">						
						<div id="subject">
							<label for="subj">Subject: </label>
								<input type="text" name="subj"><br>
						</div>
						<div class="grade">
							Grade: <select name="grad">
								<?php
								for($i = 1; $i < 101; $i++)
								{ ?>
									<option value="<?=$i; ?>"><?=$i; ?> </option>
									<?php
								} ?>
							</select><br>
						</div>
						Teacher's notes<textarea rows="4" cols="50" name="note"></textarea><br>
						<div id="record">
							<input type="submit" value="Add Record">
						</div>
					</form>			
				</div>

				<?php
			} ?>	
		</div>
	</body>
</html>

<?php
$_SESSION = array();
//unset($_SESSION);
?>