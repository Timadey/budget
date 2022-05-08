<?php
session_start();
if (!isset($_SESSION["email"]) && !isset($_SESSION["user_id"]) && !isset($_SESSION["email"])){
    header("Location: authenticate/login.php");
    exit();
};
if (isset($_SESSION["name"]) && isset($_SESSION["user_id"]) && isset($_SESSION["email"])){
    $_SESSION = array();
    session_destroy(); 
};
if(isset($_COOKIE["email"]) && (isset($_COOKIE["user_id"])) && (isset($_COOKIE["email"]))){
    setcookie(session_name(), "", time()-3600);
    setcookie("name", "", time()-3600);
    setcookie("user_id", "", time()-3600);
    setcookie("email", "", time()-3600);
};
header("Location: authenticate/login.php");
?>