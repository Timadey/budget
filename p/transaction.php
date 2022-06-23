<?php
session_start();
require_once "../config.php";

/** 
 * if post data sent was to log transaction
*/
// echo "<pre>";
// var_dump($_POST);
// echo "</pre>";
// exit;
if (isset($_POST['log-transaction'])){
    $book_id = clean($_POST['book-id']);
    $amount = clean($_POST['amount']);
    $sub_category_id = clean($_POST['sub-category']);
    $desc = clean($_POST['description']);
    $category_id = clean($_POST['category-id']);
    if ($book_id == "" or $amount == "" or $sub_category_id == "" or $desc == "" ){
        $_SESSION['msg'] = alert("One or more empty field", 0);
        header("Location: ../transaction.php");
        exit();
    };

    /**
      * confirm this book belongs to user
      */
      $val = [':bk_id' => $book_id, ':uid' => $_SESSION['user_id']];
      $book_exist = $dbs->dbGetData(['`book_id`'], '`books`', null, 
      ['book_id' => ':bk_id','user_id' => ':uid'], $val);

      /**
      * confirm this category id exist and it corresponding sub category
      */
      $val = [':sub_id' => $sub_category_id, ':cat_id' => $category_id];
      $cat_exist = $dbs->dbGetData(['`sub_category_id`'], '`sub_category`', null,
      ['sub_category_id' => ':sub_id', 'category_id' =>':cat_id'], $val);

      if ($book_exist == null || $cat_exist == null)
      {
        include_once "../404.php";
        exit();
      }
      //check amount validity
      if(!$user->isNumValid($amount))
    {
        $_SESSION['msg'] = alert("Amount can only contain numbers", 0);
        header("Location: ../transaction.php");
        exit();
    }
      //check desc validity
    if(!$user->isNameValid($desc))
    {
        $_SESSION['msg'] = alert("Description must contain only letters, greater than 4 and less than 30 characters", 0);
        header("Location: ../transaction.php");
        exit();
    }
    //desc is valid, insert data into database
    $col = array ("`user_id`", "`book_id`", "`sub_category_id`", "`transaction_amount`", "`transaction_desc`");
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
        $_SESSION['msg'] = alert("Transaction logged successfully", 1);
        header ("Location: ../book.php?book=".$book_id);
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

    /**
     * confirm this transaction belongs to this user
    */
    $val = [':trans_id' => $trans_id, ':uid' => $_SESSION['user_id']];
    $trans_exist = $dbs->dbGetData(['`transaction_id`'], '`transactions`', null, 
    ['transaction_id' =>':trans_id', 'user_id' => ':uid'], $val);

    if ($trans_exist == null)
      {
        include_once "../404.php";
        exit();
      }
    
      //check amount validity
    if(!$user->isNumValid($amount))
    {
        $_SESSION['msg'] = alert("Amount can only contain numbers", 0);
        header("Location: ../transaction.php");
        exit();
    }
    //check desc validity
    if(!$user->isNameValid($desc))
    {
        $_SESSION['msg'] = alert("Description must contain only letters, greater than 4 and less than 30 characters", 0);
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
        '`transaction_amount`=:amount',
        '`sub_category_id`=:sub_cat',
        '`transaction_desc` =:desc'
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
        $_SESSION['msg'] = alert("Transaction edited successfully", 1);
        echo
        "<script> 
            history.go(-2);
        </script>";
    }
    else
    {
        $_SESSION['msg'] = alert("Oops! Action failed due to technical issues", 0);
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