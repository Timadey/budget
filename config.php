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
//$dbs = dbconnect($DB_HOST,$DB_USER, $DB_PASSWORD, $DB_NAME);

//dont touch
session_start();
if (!isset($_SESSION['user_id']) && !isset($_SESSION['email']) && !isset($_SESSION['name'])){
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['email']) && isset($_COOKIE['name'])){
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['email'] = $_COOKIE['email'];
        $_SESSION['name'] = $_COOKIE['name'];
        include_once "authenticate/logged_in_as.php";  
    }else{
        //header("Location: authenticate/login.php");
    };
}else{
    if (!isset($_COOKIE['user_id']) && !isset($_COOKIE['email']) && !isset($_COOKIE['name'])){
        setcookie('user_id', $_SESSION['user_id'], time()+(60 * 60 * 24 * 2));
        setcookie('email', $_SESSION['email'], time()+(60 * 60 * 24 * 2));
        setcookie('name', $_SESSION['name'], time()+(60 * 60 * 24 * 2));
    };
};

// $uid = $_SESSION['user_id'];
// $email = $_SESSION['email'];
// $name = $_SESSION['name'];
?>