<?php
	echo "shittyness\n";
	$string = file_get_contents("paulaschoicescrape.json");

	$json = json_decode($string, true);
	echo '<pre>'. print_r($json["results"][collection1][0][name],true).'</pre>';
?>