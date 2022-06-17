<?php
session_start();
 require_once "../config.php";


if (isset($_POST["login"])){
    $email = clean($_POST['email']);
    $password = ($_POST['password']);
    $data = $user->login($email, $password);
    unset($_POST);
    if ($data == true)
    {
        $_SESSION['user_id'] = $user->getUid();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['name'] = $user->getUname();
        $_SESSION['login'] = $user->getLogin();
        var_dump($_SESSION);
        echo "<script>alert('success!');</script>";
        header("Location: ../index.php");
    }
    else
    {
        echo "<script>alert('Login Failed');</script>";
        header("Location: ../authenticate/login.php");
    }
}
else{
   header("Location: ../authenticate/login.php");
};

?>