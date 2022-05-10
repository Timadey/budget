<?php
require_once "config.php";

if (isset($_GET['book'])){
    $book_id = $_GET['book'];

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
    }catch(PDOException $err){
        echo "Can't load book: ".$err->getMessage();
    };

    //book exist
    try
    {
        $query = "DELETE FROM `books` WHERE `book_id`=:book_id AND `user_id`=:user_id";
        $statement = $dbs->prepare($query);
        $statement->bindValue(':book_id', $book_id);
        $statement->bindValue(':user_id', $uid);
        $statement->execute();
        $count = $statement->rowCount();

        echo 
            "<script> 
            alert('Book deleted successfully. Total of ".$count." book deleted!');
            window.location.href = 'index.php';
            </script>"; 
    }
    catch(PDOException $err){
        echo "Error. Cannot delete book: <br>".$err->getMessage();
    };
    

}
?>