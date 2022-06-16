<?php 
require_once "modules/functions.php";
require_once "modules/database-class.php";
require_once "modules/account-class.php";

//connect to database
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASSWORD = '';
$DB_NAME ='budget';

$dbs = new Database($DB_HOST,$DB_USER, $DB_PASSWORD, $DB_NAME);
$dbs->dbConnect();
$user = new Account ($dbs);

?>