<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
header("Content-Type: application/json");
$data = array();
//$type = $_GET['type'];

/*
for ($i=0; $i<100; $i++) {
  $num = rand();
  if ($type == 'evens' && $num % 2 == 0 || $type == 'odds' && $num %2 == 1)
    array_push($data, $num);
}
*/


class Product {
            // Creating some properties (variables tied to an object)
			  public $id;            
            public $name;
            public $brand;
            public $url;
            //public $ingredients;
            public $type;
            
            // Assigning the values
            public function __construct($id, $name, $brand, $url, $type) {
              $this->id = $id;
              $this->name = $name;
              $this->brand = $brand;
              $this->url = $url;
              $this->type = $type;
            }
            
				//debug print function
				public function debugPrint(){
					echo $this->id . ", " . $this->name . ", " . $this->brand . ", " . $this->url . ", " . $this->type;
				}
 }

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
      //echo "Opened database successfully\n";
   }
   
$sql =<<<EOF
      SELECT* from Product;
EOF;

   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
      $p = new Product($row['ProductID'], $row['Name'], $row['Brand'] , $row['URL'], $row['Type']);
      array_push($data, $p);
   }
   //echo "Operation done successfully\n";
   $db->close();
   
   echo json_encode($data);
?>