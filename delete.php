<?php
session_start();
require_once "config.php";

if (isset($_GET['book'])){
    $book_id = $_GET['book'];

    //check if book exist
    try{
        $col = array ("`book_id`");
        $table = "`books`";
        $where = array ('`books`.`book_id`' => ':book_id', '`books`.`user_id`' => ':user_id');
        $val = array (':book_id' => $book_id, ':user_id' => $_SESSION['user_id']);
        try{
            $rdata = $dbs->dbGetData($col, $table, null, $where, $val);
        }
        catch(Exception $err)
        {
            $_SESSION['msg'] = alert("oops! We're experiencing technical issue at the moment", 0);
        }

        if ($rdata == null){
            echo 
                "<script> 
                alert('Book not found!');
                window.location.href = '../book.php?book=".$book_id."';
                </script>"; 
            exit();
        }
        // $query = "SELECT `book_id` FROM `books` WHERE books.book_id=:book_id AND books.user_id=:user_id";
        // $statement = $dbs->prepare($query);
        // $statement->bindValue(':book_id', $book_id);
        // $statement->bindValue(':user_id', $uid);
        // $statement->execute();
        // $rdata = $statement->fetch(PDO::FETCH_ASSOC);

        // if (!$rdata){
        //     echo 
        //     "<script> 
        //     alert('Book not found!');
        //     window.location.href = '../book.php?book=".$book_id."';
        //     </script>"; 
        // };
    }catch(PDOException $err){
        $_SESSION['msg'] = alert("Oops! Action failed due to technical issues", 0);
        echo 
            "<script> 
            window.location.href = '../book.php?book=".$book_id."';
            </script>"; 
        exit();
    };

    //book exist
    try
    {
        $table = '`books`';
        $where = array ('`book_id`=:book_id', '`user_id`=:user_id');
        $values = array (':book_id' => $book_id,':user_id' => $_SESSION['user_id']);
        $deleted = $dbs->deleteData($table, $where, $values);
        if (!$deleted){
            echo 
                "<script> 
                alert('Book not deleted due to technical issues!');
                </script>"; 
            exit();
        }

        // $query = "DELETE FROM `books` WHERE `book_id`=:book_id AND `user_id`=:user_id";
        // $statement = $dbs->prepare($query);
        // $statement->bindValue(':book_id', $book_id);
        // $statement->bindValue(':user_id', $uid);
        // $statement->execute();
        // $count = $statement->rowCount();

        echo 
        "<script> 
            alert('Book deleted successfully. Total of ".$deleted." book deleted!');
            window.location.href = 'index.php';
        </script>"; 
    }
    catch(PDOException $err){
        $_SESSION['msg'] = alert("Oops! Action failed due to technical issues", 0);
            echo 
                "<script> 
                window.location.href = '../book.php?book=".$book_id."';
                </script>"; 
            exit();
    };
    

}
elseif (isset($_POST['delete-transaction'])){
    $transaction_id = clean($_POST['delete-transaction']);
    $table = '`transactions`';
    $where = array (' `transaction_id`=:transaction_id');
    $values = array (':transaction_id' => $transaction_id);
    $deleted = $dbs->deleteData($table, $where, $values);
    if (!$deleted){
        echo 
            "<script> 
            alert('Book not deleted due to technical issues!');
            </script>"; 
        exit();
    }
    // $query = "DELETE FROM `transactions` WHERE `transaction_id`=:transaction_id";
    // $statement = $dbs->prepare($query);
    // $statement->bindValue(':transaction_id', $transaction_id);
    // $statement->execute();

    $_SESSION['msg'] = alert("Transaction deleted succesfully", 1);
    echo 
    "<script> 
        alert('Transaction deleted successfully!');
        history.back();
    </script>"; 
}
else{
    "<script> 
        history.back();
    </script>";
};

// echo "<p>";
// var_dump($_POST);
// echo "</p>";
?>