<?php

	define("UNIQUE_ID",-1);
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
		echo "name of row: {$row[name]}<br />";
		if(testIfProductAlreadyExists($row[name],$db) == false){
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
					
				$testvalue = testForRepeatIngredient($ingredient,$db);
				if($testvalue == -1){
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

						}else{
							echo "falsed to add ingredient to Ingredient Table <br />";
						}
					}
				}else{
					//if testvalue isn't -1 then it is the IngredientID value to be used for relation table
					$ingredientid = $testvalue;
				}
				
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
				echo "$ingredient <br />";
			}
			echo "<br />";
		}else{
			echo "product already exists <br />";
		}
	}
	
	function testForRepeatIngredient($ingredientToTest,&$db2){
			//prepares a statement to be executed by db
		$stmt4 = $db2->prepare('SELECT * FROM Ingredients WHERE Name=:name');
		if($stmt4){
			//succesfully prepared statement for test ingredient, now binding data and executing
			echo "succesfully prepared statement for duplicate search <br />";
			$stmt4->bindValue(':name',$ingredientToTest);
			$result4 = $stmt4->execute();
			if($roww = $result4->fetchArray()){
				echo "duplicate exists";
				echo "name: {$roww[Name]} <br />";
				echo "id: {$roww[IngredientsID]} <br />";
				return $roww[IngredientsID];
			};
		}else{
			echo "failed to prepare statement for repeat ingredients<br />";
		}
		
		return -1;
	}
	
	function testIfProductAlreadyExists($productToTest,&$db3){
		echo "name to find: $productToTest <br />";
		$stmt5 = $db3->prepare('SELECT * FROM Product WHERE Name=:name');
		if($stmt5){
			echo "succesfully prepared product search statement <br />";
			$stmt5->bindValue(':name',$productToTest);
			$result5 = $stmt5->execute();
			if($rowww = $result5->fetchArray()){
				echo "array of products that exist with given name<br />";
				echo sizeof($rowww);
				print_r($rowww);
				echo "<br />";
				if(sizeof($rowww)> 0){
					return true;
				}
			}
		}else{
			echo "failed to prepare statement for product search <br />";
		}
		return false;
	}
?>