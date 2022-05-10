<?php
require_once "../config.php";
// echo "<p>";
// var_dump($_POST);
// echo "</p>";

if (isset($_POST['add-book'])){
    $book_name = trim($_POST['book-name']);
    $book_desc = trim($_POST['book-desc']);
    $book_type = trim($_POST['book-type']);

    if ($book_name == "" || $book_desc == "" || $book_type == ""){
        header("Location: ../newbook.php");
    }
    else{
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
            window.location.href = '../index.php';
            </script>"; 
        }
        catch(PDOException $err){
            echo "Error. Cannot add book: ".$err->getMessage();
        };
    };

}elseif (isset($_POST['edit-book'])){
    $book_id = trim($_POST['book-id']);
    $book_name = trim($_POST['book-name']);
    $book_desc = trim($_POST['book-desc']);

    if ($book_name == "" || $book_desc == "" || $book_id == ""){
        header("Location: ../newbook.php");
    }else{
        //check if book exist
        try{
            $query = "SELECT `book_id` FROM `books` WHERE books.book_id=:book_id AND books.user_id=:user_id";
            $statement = $dbs->prepare($query);
            $statement->bindValue(':book_id', $book_id);
            $statement->bindValue(':user_id', $uid);
            $statement->execute();
            $rdata = $statement->fetch(PDO::FETCH_ASSOC);
    
            if (!$rdata){
                echo 
                "<script> 
                alert('Book not found!');
                window.location.href = '../book.php?book=".$book_id."';
                </script>"; 
            };
        }
        catch(PDOException $err){
            echo "Can't load book: ".$err->getMessage();
        };
        //book exist, update book
        try{
            $query = "UPDATE `books` SET `book_name`=:book_name, `description`=:book_desc WHERE `book_id`=:book_id";

            $statement = $dbs->prepare($query);
            $statement->bindValue(':book_name', $book_name);
            $statement->bindValue(':book_desc', $book_desc);
            $statement->bindValue(':book_id', $book_id);
            $statement->execute();
            
            echo 
            "<script> 
            alert('Book updated successfully');
            window.location.href = '../book.php?book=".$book_id."';
            </script>"; 
        }
        catch(PDOException $err){
            echo "Error. Cannot add book: ".$err->getMessage();
        };
    };
}
else{
    header("Location: ../newbook.php");
};

?>