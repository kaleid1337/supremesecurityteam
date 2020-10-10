<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'epiz_26933006_hexed');
define('DB_USERNAME', 'epiz_26933006');
define('DB_PASSWORD', 'WcWaODXqnaZ');
define('ERROR_MESSAGE', 'Could not connect to database.');
//Make sure to give DB Full access.

try {
$odb = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
}
catch( PDOException $Exception ) {
 die(ERROR_MESSAGE);
}
?>
