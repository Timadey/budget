<?php 
session_start();
require_once "../config.php";
// echo "<p>";
// var_dump($_POST);
// echo "</p>";
if (isset($_POST["register"])){
  $first_name = clean($_POST["first-name"]);
  $last_name = clean($_POST["last-name"]);
  $email = clean($_POST["email"]);
  $password = $_POST["password"];

  $reg_id = $user->addAccount($first_name, $last_name, $email, $password);
  if ($reg_id > 0)
  {
    echo "<script>alert('Registration Successful. Please Login.');</script>";
    header("Location: ../authenticate/login.php");
  }
  else{
    echo "<script>alert('Registration Failed.');</script>";
    header("Location: ../authenticate/signup.php");
  }

}else{
  header("Location: ../authenticate/signup.php");
};
