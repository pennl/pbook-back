<?php
require 'vendor/autoload.php'; // include Composer's autoloader
ini_set('mbstring.substitute_character', "none");

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->test->index;

//$result = $collection->find( [ 't' => $_GET['name'], 'c' => $_GET['start'] ] );
$result = $collection->find( );
$i=0;
foreach ($result as $entry) {
   $json[$i] = $entry;
   $i +=1;
}
echo "pbook_index('".json_encode($json)."')";
?>
