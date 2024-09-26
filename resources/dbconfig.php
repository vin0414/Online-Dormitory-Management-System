<?php
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','id19581513_root');
define('DB_PASS','(hZxZN1n67KBNZfH');
define('DB_NAME','id19581513_dormitory');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>