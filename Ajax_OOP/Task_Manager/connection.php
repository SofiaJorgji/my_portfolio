<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_DATABASE', 'task');

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

if(mysqli_connect_errno())
{
        echo "error connecting to database:<br>";
        echo mysqli_connect_errno();
}

function fetch_all($connection, $query)
{
$result = mysqli_query($connection, $query);
		$data = array();

		if(mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$data[] = $row;
			}

			return $data;
		}
		else
		{
			return FALSE;
		}
}

?>
