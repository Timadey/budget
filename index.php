<?php
$page_title = "Home";
include_once "config.php";
//include_once "session.php";
include_once "template/header.php";


try{
    $query = "SELECT * FROM `books` WHERE `user_id`=:user_id ORDER BY `date` DESC";
    $statement = $dbs->prepare($query);
    $statement->bindValue(':user_id', $uid);
    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    
}catch(PDOException $err){
    echo "Failed to load books: ".$err->getMessage();
};


if ($data){
    //load all books
}else{?>
    <div class="card text-center">
        <div class="card-header">
            Budget
        </div>
        <div class="card-body">
            <h5 class="card-title">Income and Expenditure</h5>
            <p class="card-text">Record and keep tracks of your expensese. <br> Open <em>a new book</em> to start using <b>Budget</b></p>
            <a href="newbook.php" class="btn btn-primary">Open a New Book</a>
        </div>
        <div class="card-footer text-muted">
            © 2022
        </div>
    </div>
        
<?php }
?>

    
<?php
// echo "<p>";
// var_dump($_SESSION);
// echo "</p>";
include_once "template/footer.php";

?>