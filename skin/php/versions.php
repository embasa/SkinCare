<?php
	class MyDB extends SQLite3
	{
		function __construct()
		{
			$this->open('test.db');
		}
	}
	$db = new MyDB();
	if(!$db){
		echo $db->lastErrorMsg();
	} else {
		echo "Opened database successfully\n\n";
	}

	$sql =<<<EOF
		CREATE TABLE Ingredients 
		(IngredientsID	INT PRIMARY KEY	NOT NULL,
		NAME			TEXT			NOT NULL);
EOF;

	$sql2 =<<<EOF
		CREATE TABLE Product
		(ProductID	INT PRIMARY KEY	NOT NULL,
		Name		TEXT			NOT NULL,
		Brand		TEXT			NOT NULL,
		URL     	TEXT			NOT NULL);
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
	} else {
		echo "Ingredients created successfully\n";
	}
	
	//products table
	$ret = $db->exec($sql2);	
	if(!$ret){
		echo $db->lastErrorMsg();
	} else {
		echo "Product created successfully\n";
	}

	$ret = $db->exec($sql3);	
	if(!$ret){
		echo $db->lastErrorMsg();
	} else {
		echo "ProductIngredients created successfully\n";
	}
	$db->close();
?>