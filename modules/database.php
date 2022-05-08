<?php

//connect to database
function dbconnect($host, $user, $password, $name){
    try{
        $conn = new PDO("mysql:host=$host;dbname=$name", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    catch(PDOException $err){
        echo "Connection failed: ". $err->getMessage();
    }
}
?>