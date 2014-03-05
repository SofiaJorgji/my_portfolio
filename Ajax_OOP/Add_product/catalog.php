<?php
require_once("connection.php");

class Catalog
{
	private $db;
	public function __construct()
	{
		$this->db = new Database();
	}

	public function display_prod()
	{
		$query = "SELECT products.name AS prod_name, products.description AS prod_description, 
				  categories.category_name AS category_name, products.id AS prod_id
				  FROM products
				  JOIN categories ON products.categories_id = categories.id";
		$result = $this->db->fetch_all($query);
		return $result;
	}

	public function add_prod($name, $description, $categories_id)
	{
		$query = "INSERT INTO products (name, description, created_at, updated_at, categories_id)
					  VALUES ('".$name."', '".$description."', NOW(), NOW(), $categories_id)";
		$result = mysqli_query($this->db->connection, $query);
		if($result)
 		{ 				
			$prod_id = mysqli_insert_id($this->db->connection); 
			return $prod_id ;
 		}
 		else
		{
			return false;	
		}
	}

	public function update_prod($name, $description, $prod_id)
	{
		$query = "UPDATE products SET name = '". $name ."', description = '". $description ."', updated_at = NOW()
				  WHERE id = '". $prod_id ."'";
		$result = mysqli_query($this->db->connection, $query);
		return $result ;
	}

	public function delete_prod($prod_id)
	{
		$query = "DELETE FROM products
				  WHERE id = '". $prod_id ."'";
		$result = mysqli_query($this->db->connection, $query);
		return $result;
	}
	public function get_cat($cat_id)
	{
		$query = "SELECT category_name FROM categories 
				  WHERE id = ".$cat_id;
		$result = $this->db->fetch_all($query);
		return $result;					
	}
}

?>