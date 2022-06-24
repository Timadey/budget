<?php

//connect to database
// function dbconnect($host, $user, $password, $name){
//     try{
//         $conn = new PDO("mysql:host=$host;dbname=$name", $user, $password);
//         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         return $conn;
//     }
//     catch(PDOException $err){
//         echo "Connection failed: ". $err->getMessage();
//     }
// }


/**
 * clean - clean user's form input
 * @input: input to clean
 * Return: the cleaned input
 */
function clean($input){
    $input = htmlspecialchars($input);
    $input = strip_tags($input);
    $input = trim($input);
    return $input;
}
/**
 * alert - bootstrap alert messages
 * @msg: alert messages
 * @status: alert status; 0 for failure, 1 for success
 * Return: a bootstrap alert div containing the alert message
 */
function alert (string $msg, int $status)
{
    if ($status == 0)
    {
        return ("<div class = 'alert alert-danger' role = 'alert'><strong>".$msg."</strong></div>");
    }
    else if ($status == 1)
    {
        return ("<div class = 'alert alert-success' role = 'alert'><strong>".$msg."</strong></div>");
    }
}
?>