<?php
session_start();
$page_title = "Home";
include_once "template/header.php";
?>

    <div class="card text-center">
    <div class="card-header">
        Featured
    </div>
    <div class="card-body">
        <h5 class="card-title">Income and Expenditure</h5>
        <p class="card-text">Record and keep tracks of your expenses. Login to open a new book.</p>
        <a href="authenticate/login.php" class="btn btn-primary">Log in</a>
    </div>
    <div class="card-footer text-muted">
        © 2020
    </div>
    </div>
    
<?php
// echo "<p>";
// var_dump($_SESSION);
// echo "</p>";
include_once "template/footer.php";

?>