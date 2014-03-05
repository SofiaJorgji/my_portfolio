<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_DATABASE', 'product');

class Database
{
	public $connection;  
	public function __construct()
	{
		$this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
	}

	public function fetch_all($query)  
	{
		$data = array();
		$result = mysqli_query($this->connection, $query);
		while($row = mysqli_fetch_assoc($result))
		{
			$data[] = $row;
		}
		return $data;
	}

	public function fetch_record($query)
	{
		$result = mysqli_query($this->connection, $query);
		return mysqli_fetch_assoc($result);
	}
}

?>
