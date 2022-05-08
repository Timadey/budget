<?php
require_once "../config.php";
echo "<p>";
var_dump($_POST);
echo "</p>";

if (isset($_POST['add-book'])){
    $book_name = trim($_POST['book-name']);
    $book_desc = trim($_POST['book-desc']);
    $book_type = trim($_POST['book-type']);

    if ($book_name == "" || $book_desc == "" || $book_type == ""){
        echo
        "<script> 
          alert('Entries can't be empty!');
          window.location.href = '../newbook.php';
        </script>"; 
    }else{
        try{
            $query = "INSERT INTO `books` (`user_id`, `book_name`, `category_id`, `description`) 
            VALUE (:user_id, :book_name, :category_id, :description)";

            $statement = $dbs->prepare($query);
            $statement->bindValue(':user_id', $uid);
            $statement->bindValue(':book_name', $book_name);
            $statement->bindValue(':category_id', $book_type);
            $statement->bindValue(':description', $book_desc);
            $statement->execute();
            
            echo 
            "<script> 
            alert('Book added successfully');
            window.location.href = '../newbook.php';
            </script>"; 
        }catch(PDOException $err){
            echo "Error. Cannot add book: ".$err->getMessage();
        };
    };

}else{
    header("Location: ../newbook.php");
};

?>