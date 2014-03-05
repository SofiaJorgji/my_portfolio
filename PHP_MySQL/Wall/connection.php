<?php
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', 'root');
	define('DB_DATABASE', 'wall');


	$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

	if(mysqli_connect_errno())
	{
	        echo "error connecting to database:<br>";
	        echo mysqli_connect_errno();
	}
	// $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS) or 
	// 	die('Could not connect to the database host (please double check the settings in connection.php): ' . mysqli_error());
	// $db_selected = mysqli_select_db(DB_DATABASE, $connection) or 
	// 	die ('Could not find a database with the name "'.DB_DATABASE.'" 
	// 	(please double check your settings in connection.php): ' . mysqli_error());
	function fetch_all($connection, $query)
	{
	        $data = array();

	        $result = mysqli_query($connection, $query);
	        while($row = mysqli_fetch_assoc($result))
	        {
	                $data[] = $row;
	        }
	        return $data;
	}
	// function fetch_all($query)
	// {
	// 	$data = array();

	// 	$result = mysqli_query($query);
	// 	while($row = mysqli_fetch_assoc($result))
	// 	{
	// 		$data[] = $row;
	// 	}

	// 	return $data;
	// }

	//fetch the first record obtained from the query
	// function fetch_record($query)
	// {
	// 	$result = mysqli_query($query);
	// 	return mysqli_fetch_assoc($result);
	// }
	function fetch_record($connection, $query)
	{
	        $result = mysqli_query($connection, $query);
	        return mysqli_fetch_assoc($result);
	}
?>