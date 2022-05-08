<?php require_once "../config.php";

if (isset($_POST["login"])){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM `users` WHERE `email`=:email";
    $statment = $dbs->prepare($query);
    $statment->bindValue(':email', $email);
    $statment->execute();
    $data = $statment->fetchAll(PDO::FETCH_ASSOC);

    if ($data){
        $query = "SELECT * FROM `users` WHERE `email`=:email AND `password`=SHA(:password)";
        $statment = $dbs->prepare($query);
        $statment->bindValue(':email', $email);
        $statment->bindValue(':password', $password);
        $statment->execute();
        $data = $statment->fetch(PDO::FETCH_ASSOC);
        
       $_SESSION['user_id'] = $data['user_id'];
       $_SESSION['email'] = $data['email'];
       $_SESSION['name'] = $data['first_name'].' '.$data['last_name'];

       header("Location: ../index.php");
        // echo "<p>";
        // var_dump($_SESSION);
        // echo "</p>";

    };
}
else{
   header("Location: ../authenticate/login.php");
};

?>