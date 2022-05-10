<?php
require_once "../config.php";
// echo "<p>";
// var_dump($_POST);
// echo "</p>";
if (isset($_POST['log-transaction'])){
    $book_id = trim($_POST['book-id']);
    $type = trim($_POST['type']);
    $amount = trim($_POST['amount']);
    $sub_category_id = trim($_POST['sub-category']);
    $desc = trim($_POST['description']);

    if (($book_id || $type || $amount || $sub_category_id || $desc) == ""){
        header ("Location: ../book.php?book=".$book_id);
    };

    $query = "INSERT INTO `transactions` (`user_id`, `book_id`, `sub_category_id`, `amount`, `type`, `description`)
    VALUES (:user_id, :book_id, :sub_cat_id, :amount, :type, :desc)";
    $statement = $dbs->prepare($query);
    $statement->bindValue(':user_id', $uid);
    $statement->bindValue(':book_id', $book_id);
    $statement->bindValue(':sub_cat_id', $sub_category_id);
    $statement->bindValue(':amount', $amount);
    $statement->bindValue(':type', $type);
    $statement->bindValue(':desc', $desc);
    $statement->execute();

    echo
    "<script> 
        alert('Transaction logged successfully!');
        window.location.href = '../book.php?book=".$book_id."';
    </script>";


}
else{
    echo "post not set";
}
?>