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
		echo "Opened database successfully<br />";
	}
	echo "beginning of scrap.php<br />";
	$string = file_get_contents("paulaschoicescrape.json");
	
	$json = json_decode($string, true);
	echo "name of brand: {$json["name"]} <br />";
	//echo '<pre>'. print_r($json["results"][collection1],true).'</pre>';
	$count = 0;
	foreach ($json["results"][collection1] as $row){
			//var_dump($row->fetchArray());
			//echo '<pre>'. print_r($row,true).'</pre>';
			$name = $row[name];
			$ingredients = $row[ingredients];
			$url = $row[url];
			
			//split string of ingredients into individual ingredients for adding to database
			$individual_ingredients = explode(", ",$ingredients);

			$stmt = $db->prepare('INSERT INTO Product(ProductID,Name,Type,Brand,URL) VALUES(:id,":name","cleanser",":brand",":url")');
			if($stmt){
				echo "statement <br />";
			}else{
				echo "unprepared <br />";
			}/**/
			$stmt->bindValue(':id',++$count);
			$stmt->bindParam(':name',$name);
			$stmt->bindParam(':brand',$json["name"]);
			$stmt->bindParam(':id',++$count);	/**/		
			
			echo "name: $name <br />";
			echo "url: $url <br />";
			foreach($individual_ingredients as $ingredient){
				echo "$ingredient <br />";
			}
			echo "<br />";
			/*	
			if($db->exec('INSERT INTO Product (ProductID,Name,Type,Brand,URL) VALUES (2,"Chenski","lube","AsianFlare","www.ownit.com")')){
				echo "query successsssfull <br />";
			}else{
				echo "query failed babbbyyy <br />";
			}*/
			/*foreach($row as $column){
				echo "{$column}<br />";
			}*/
			//echo '<pre>'. print_r($row,true).'</pre>';
	}
	
	
?>