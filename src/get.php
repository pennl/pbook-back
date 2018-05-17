<?php
require 'vendor/autoload.php'; // include Composer's autoloader
ini_set('mbstring.substitute_character', "none");

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->test->books;
$t = mb_convert_encoding($_GET['name'], 'UTF-8', 'UTF-8');
$c = $_GET['start'];
$json = null;
//echo $t,$c;
//echo PHP_EOL,md5($t),' : ',md5($_GET['name']),' : ',md5('狩魔手记'),PHP_EOL;
$result = $collection->find( [ 't' => $t, 'c' => intval($c)] );
//$result = $collection->find( [ 't' => '狩魔手记', 'c' => 1 ] );
//print_r($result);
foreach ($result as $entry) {
//print_r($entry);
   $json = $entry;
}

echo "pbook_chapter('".json_encode($json)."')";
?>
