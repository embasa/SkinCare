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

	//The collection is from kimono labs scrapper.
	foreach ($json["results"][collection1] as $row){
			//add product meta data

			//prepare statement for adding product to Product Table
			$stmt = $db->prepare('INSERT INTO Product(Name,Type,Brand,URL) VALUES(:name,"cleanser",:brand,:url)');
			if($stmt){
				//if statement successfully prepared, then bind data and execute it
				echo "statement prepared for adding Product to Product Table<br />";
				$stmt->bindValue(':name',$row[name]);
				$stmt->bindValue(':brand',$json["name"]);
				$stmt->bindValue(':url',$row[url]);	/**/		
				$result = $stmt->execute();
				if($result){
					//if execution is successful retrieve the ID to use for relations table
					echo "added product to Product Table <br />";
					$productid = $db->lastInsertRowID();
					//echo "productid: $productid <br />";
				}else{
					echo "failed to add product to Product Table <br />";
				}
			}else{
				echo "statement unprepared <br />";
			}
			
			//split string of ingredients into individual ingredients for adding to Ingredients Table
			$individual_ingredients = explode(", ",$row[ingredients]);

			foreach($individual_ingredients as $ingredient){
				echo "productid: $productid <br />";//product id corresponding to current ingredient list
				
				/* check here if ingredient is already in table
					if it is then retrieve its ID and use that for 
					relation table instead of generating new one*/
				
				//prepare statement for adding ingredient to Ingredient Table
				$stmt2 = $db->prepare('INSERT INTO Ingredients(Name) VALUES (:name)');
				if($stmt2){
					//if statement successfully prepared bind data and execute
					echo "statement prepared for adding to Ingredient Table <br />";
					$stmt2->bindValue(':name',$ingredient);
					$result2 = $stmt2->execute();
					if($result2){
						//if executed succesfully take ingredient id to use for relation table
						echo "added ingredient to Ingredient Table <br />";
						$ingredientid = $db->lastInsertRowID();
						echo "ingredientid: $ingredientid <br />";
						//prepare statement for relation table
						$stmt3 = $db->prepare('INSERT INTO ProductIngredients(ProductID,IngredientsID) VALUES(:PID,:IID)');
						if($stmt3){
							//if succesfully prepared, then bind both ids to relation table
							echo "statement prepared for relation table <br />";
							$stmt3->bindValue(':PID',$productid);
							$stmt3->bindValue(':IID',$ingredientid);
							$result3 = $stmt3->execute();
							if($result3){
								echo "successfully added to relation table <br />";
							}else{
								echo "failed to add to relation table <br />";
							}
						}else{
							echo "statement failed for relation table <br />";
						}
					}else{
						echo "falsed to add ingredient to Ingredient Table <br />";
					}
				}
				echo "$ingredient <br />";
			}
			echo "<br />";
	}
	
	function testForRepeatIngredient($ingredientToTest){
			//prepares a statement to be executed by db
		$stmt4 = $db->prepare('SELECT * FROM Ingredients WHERE Name=:name');
		if($stmt4){
			//succesfully prepared statement for test ingredient, now binding data and executing
			echo "succesfully prepared statement for duplicate search <br />";
			$stmt4->bindValue(':name',$ingredientToTest);
			$result4 = $stmt4->execute();
			while($roww = $result4->fetchArray()){
			
			};
		}else{
			echo "failed to prepare statement for repeat ingredients<br />";
		}

		//returns a row as an associative array 
		while($row = $result->fetchArray()){
			echo "ProductID: {$row[ProductID]} <br />";
			echo "Name: {$row[Name]} <br />";
			echo "Type: {$row[Type]} <br />";
			echo "Brand: {$row[Brand]}<br />";
			echo "URL: {$row[URL]} <br />";
		}
		return false;
	}
?>