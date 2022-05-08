<?php require_once "../config.php";
// echo "<p>";
// var_dump($_POST);
// echo "</p>";
if (isset($_POST["register"])){
  $first_name = trim($_POST["first-name"]);
  $last_name = trim($_POST["last-name"]);
  $email = trim($_POST["email"]);
  $password = trim($_POST["password"]);

  //check if user exists
  $query = "SELECT * FROM users WHERE `email`=:email";
  $statement = $dbs->prepare($query);
  $statement->bindValue(':email', $email);
  $statement->execute();
  $data = $statement->fetchAll(PDO::FETCH_ASSOC);
 
  if (!$data){
    try{
    
        $query = "INSERT INTO users (first_name, last_name, email, password)
        VALUES (:first_name, :last_name, :email, SHA(:password))";
       
        $statement = $dbs->prepare($query);
        
        //$statement->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();
        echo 
        "<script> 
          alert('User registered successfully, please login.');
          window.location.href = '../authenticate/login.php';
        </script>";
        
    }catch(PDOException $err){
      echo "Error: ".$err->getMessage();
    };

  }else{
      //user already exist
      echo
      "<script> 
        alert('User already exist, please login.');
        window.location.href = '../authenticate/login.php';
      </script>";
  };
}else{
  header("Location: ../authenticate/signup.php");
};
$_POST = array();