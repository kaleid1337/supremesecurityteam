<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'DB_NAME');
define('DB_USERNAME', 'DB_USER');
define('DB_PASSWORD', 'DB_PASSWORD');
define('ERROR_MESSAGE', 'Could not connect to database.');
//Make sure to give DB Full access.

try {
$odb = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
}
catch( PDOException $Exception ) {
 die(ERROR_MESSAGE);
}
?>
