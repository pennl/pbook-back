<?php
require 'vendor/autoload.php'; // include Composer's autoloader

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->test->books;

$result = $collection->find( [ 't' => '庆余年', 'c' => 200 ] );

foreach ($result as $entry) {
    print_r(array($entry));
}
?>
