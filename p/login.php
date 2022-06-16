<?php require_once "../config.php";
session_start();

if (isset($_POST["login"])){
    var_dump($_POST);
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
    elseif ($data == 1)
    {
        echo "<script>alert('User already exist');</script>";
    }
    else{
        echo "<script>alert('Login Failed');</script>";
        echo password_hash("admin", PASSWORD_DEFAULT);
        //header("Location: ../authenticate/login.php");
    }
}
else{
   //header("Location: ../authenticate/login.php");
};

?>