<?php
define('DB_HOST', 'sql308.epizy.com');
define('DB_NAME', 'epiz_26933323_hexed');
define('DB_USERNAME', 'epiz_26933323');
define('DB_PASSWORD', '9Xianwf4Y5');
define('ERROR_MESSAGE', 'Could not connect to database.');
//Make sure to give DB Full access.

try {
$odb = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
}
catch( PDOException $Exception ) {
 die(ERROR_MESSAGE);
}
?>
