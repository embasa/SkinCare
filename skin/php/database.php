<?php
	class MyDB extends SQLite3
	{
		function __construct()
		{
			$this->open('skin.db');
		}
	}
	$db = new MyDB();
	if(!$db){
		echo $db->lastErrorMsg();
	} else {
		echo "Opened database successfully<br />";
	}

	$sql =<<<EOF
		CREATE TABLE Ingredients 
		(IngredientsID	INTEGER PRIMARY KEY AUTOINCREMENT,
		Name			TEXT			NOT NULL);
EOF;

	$sql2 =<<<EOF
		CREATE TABLE Product
		(ProductID	INTEGER PRIMARY KEY	AUTOINCREMENT,
		Name		TEXT			NOT NULL,
		Type		TEXT			NOT NULL,
		Brand		TEXT			NOT NULL,
		URL     	TEXT);
EOF;

	$sql3 =<<<EOF
		CREATE TABLE ProductIngredients
		(ProductID		INT			NOT NULL,
		IngredientsID	INT			NOT NULL);
EOF;


	//ingredients table
	$ret = $db->exec($sql);	
	if(!$ret){
		echo $db->lastErrorMsg();
		echo"<br />";
	} else {
		echo "Ingredients created successfully<br />";
	}
	
	//products table
	$ret = $db->exec($sql2);	
	if(!$ret){
		echo $db->lastErrorMsg();
		echo"<br />";
	} else {
		echo "Product created successfully<br />";
	}
	//productingredient relations table
	$ret = $db->exec($sql3);	
	if(!$ret){
		echo $db->lastErrorMsg();
		echo"<br />";
	} else {
		echo "ProductIngredients created successfully<br />";
	}

	
	//prepares a statement to be executed by db
	$stmt = $db->prepare('SELECT * FROM Product');

	//executes the statement and returns an sqlite3result object
	$result = $stmt->execute();
	echo "executed<br />";

	//returns a row as an associative array 
	while($row = $result->fetchArray()){
		echo "ProductID: {$row[ProductID]} <br />";
		echo "Name: {$row[Name]} <br />";
		echo "Type: {$row[Type]} <br />";
		echo "Brand: {$row[Brand]}<br />";
		echo "URL: {$row[URL]} <br />";
	}
	
	if($db->exec('DELETE FROM Product WHERE Type="Cleanser"')){
		echo "row deleted <br />";
	}else{
		echo "row NOT deleted <br />";
	}
	echo "done...<br />";
	$db->close();
?>