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
		Type		TEXT			NOT NULL,
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
	if($db->exec('INSERT INTO Product (ProductID,Name,Type,Brand,URL) VALUES (1,"Chenski","lube","AsianFlare","www.ownit.com")')){
		echo "query successsssfull\n\n\n";
	}
	$stmt = $db->prepare('SELECT * FROM Product');
	echo "prepared stmt";
	$result = $stmt->execute();
	echo "executed stms";
	var_dump($result->numColumns());
/*	if($result = $db->query('SELECT * FROM Product'))
	{
		echo "SDFSDFSDFSDFSFD";
		echo $result->fetchArray();
		while($row = $result->fetchArray()){
			//echo "Name: {$row[Name]} <br />";
			echo "shitnessgracious";
		}

	}*/
	echo "momammamamamamam";
	$db->close();
?>