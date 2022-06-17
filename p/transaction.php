<?php
session_start();
require_once "../config.php";

/** 
 * if post data sent was to log transaction
*/
if (isset($_POST['log-transaction'])){
    $book_id = clean($_POST['book-id']);
    $amount = clean($_POST['amount']);
    $sub_category_id = clean($_POST['sub-category']);
    $desc = clean($_POST['description']);
    if ($book_id == "" or $amount == "" or $sub_category_id == "" or $desc == "" ){
        $_SESSION['msg'] = "One or more empty field";
        header("Location: ../transaction.php");
        exit();
    };

    //check desc validity
    if(!$user->isNameValid($desc))
    {
        $_SESSION['msg'] = "Description must be greater than 4 and less than 30 characters";
        header("Location: ../transaction.php");
        exit();
    }
    //desc is valid, insert data into database
    $col = array ("`user_id`", "`book_id`", "`sub_category_id`", "`amount`", "`description`");
    $val = array (
        ':user_id' => $_SESSION['user_id'],
        ':book_id' => $book_id,
        ':sub_cat_id' => $sub_category_id,
        ':amount' => $amount,
        ':desc' => $desc
    );
    $insert_id = $dbs->insertData("`transactions`", $col, $val);
    if ($insert_id > 0)
    {
        $_SESSION['msg'] = "Transaction logged successfully";
        header("Location: ../transaction.php");
        exit();
    }


    // $query = "INSERT INTO `transactions` (`user_id`, `book_id`, `sub_category_id`, `amount`, `description`)
    // VALUES (:user_id, :book_id, :sub_cat_id, :amount, :desc)";
    // $statement = $dbs->prepare($query);
    // $statement->bindValue(':user_id', $uid);
    // $statement->bindValue(':book_id', $book_id);
    // $statement->bindValue(':sub_cat_id', $sub_category_id);
    // $statement->bindValue(':amount', $amount);
    // //$statement->bindValue(':type', $type);
    // $statement->bindValue(':desc', $desc);
    // $statement->execute();


}
/**
 * if post data sent was to edit transaction
 */
elseif (isset($_POST['edit-transaction'])){
    /**
     * get post data
     */
    $amount = clean($_POST['amount']);
    $sub_cat = clean($_POST['sub-category']);
    $desc = clean($_POST['description']);
    $trans_id = clean($_POST['transaction-id']);

    //check desc validity
    if(!$user->isNameValid($desc))
    {
        $_SESSION['msg'] = "Description must be greater than 4 and less than 30 characters";
        echo
        "<script> 
            history.go(-2);
        </script>";
        exit();
    }
    
    /**
     * update transaction query
     */
    $table = '`transactions`';
    $set = array (
        '`amount`=:amount',
        '`sub_category_id`=:sub_cat',
        '`description` =:desc'
    );
    $where = array ('`transaction_id`=:trans_id');
    $value = array (
        ':amount' => $amount,
        ':sub_cat' => $sub_cat,
        ':desc' => $desc,
        'trans_id' => $trans_id
    );
    $updated = $dbs->updateData($table, $set, $where, $value);
    if ($updated == true)
    {
        $_SESSION['msg'] = "Transaction edited successfully";
        echo
        "<script> 
            history.go(-2);
        </script>";
    }
    else
    {
        $_SESSION['msg'] = "Oops! Action failed due to technical issues";
            echo
        "<script> 
            history.go(-2);
        </script>";
    }
    // $query = "UPDATE `transactions` SET `amount`=:amount, `sub_category_id`=:sub_cat, `description`=:desc WHERE `transaction_id`=:trans_id";
    // $statement = $dbs->prepare($query);
    // $statement->bindValue(':amount', $amount);
    // $statement->bindValue(':sub_cat', $sub_cat);
    // $statement->bindValue(':desc', $desc);
    // $statement->bindValue(':trans_id', $trans_id);
    // $statement->execute();
}
else{
    header ("Location: ../book.php?book=".$book_id);
}
?>