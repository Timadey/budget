<?php require_once "../config.php";

if (isset($_POST["login"])){
    var_dump($_POST);
    $email = clean($_POST['email']);
    $password = ($_POST['password']);
    $data = $user->login($email, $password);

    if ($data)
    {
        echo "success!";
    }else{
        echo "login failed";
    }

    // $query = "SELECT * FROM `users` WHERE `email`=:email";
    // $statment = $dbs->prepare($query);
    // $statment->bindValue(':email', $email);
    // $statment->execute();
    // $data = $statment->fetchAll(PDO::FETCH_ASSOC);

    // if ($data){
    //     $query = "SELECT * FROM `users` WHERE `email`=:email AND `password`=SHA(:password)";
    //     $statment = $dbs->prepare($query);
    //     $statment->bindValue(':email', $email);
    //     $statment->bindValue(':password', $password);
    //     $statment->execute();
    //     $data = $statment->fetchAll(PDO::FETCH_ASSOC);
        
    //    $_SESSION['user_id'] = $data['user_id'];
    //    $_SESSION['email'] = $data['email'];
    //    $_SESSION['name'] = $data['first_name'].' '.$data['last_name'];

       
    //     // echo "<p>";
    //     // var_dump($_SESSION);
    //     // echo "</p>";

    // }else{
    //     header("Location: ../authenticate/login.php");
    // };
}
else{
   //header("Location: ../authenticate/login.php");
};

?>