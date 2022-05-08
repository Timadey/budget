<?php 
require_once "modules/database.php";

//connect to database
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASSWORD = '';
$DB_NAME ='budget';
global $dbs;
$dbs = dbconnect($DB_HOST,$DB_USER, $DB_PASSWORD, $DB_NAME);

?>