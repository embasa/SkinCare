<?php
header("Content-Type: application/json");
$data = array();
$type = $_GET['type'];
for ($i=0; $i<100; $i++) {
  $num = rand();
  if ($type == 'evens' && $num % 2 == 0 || $type == 'odds' && $num %2 == 1)
    array_push($data, $num);
}
echo json_encode($data);
?>
