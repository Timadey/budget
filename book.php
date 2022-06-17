<?php
$page_title = "Book";
include_once "session.php";
include_once "config.php";
include_once "template/header.php";

if (isset($_GET['book'])){
    $book_id = clean($_GET['book']);
    //check if book exist
    
    $col = array ("`book_name`", "`book_id`", "`category_id`", "`description`");
    $table = "`books`";
    $where = array ('`books`.`book_id`' => ':book_id', '`books`.`user_id`' => ':user_id');
    $val = array (':book_id' => $book_id, ':user_id' => $_SESSION['user_id']);
    try{
        $rdata = $dbs->dbGetData($col, $table, null, $where, $val);
    }
    catch(Exception $err)
    {
        $_SESSION['msg'] = "oops! We're experiencing technical issue at the moment";
    }
    
    if ($rdata == null){
        include_once "404.php";
        exit();
    };
    $rdata = $rdata[0];
    
    try{
        $table = "`books`";
        $join = array ('`transactions`' => '`book_id`', '`sub_category`' => '`sub_category_id`');
        $where = array ('`books`.`book_id`' => ':book_id', '`books`.`user_id`' => ':user_id', '`sub_category`.`category_id`' => ':book_type');
        $val = array (':book_id' => $book_id, ':user_id' => $_SESSION['user_id'], ':book_type' => $rdata['category_id']);
        try{
            $data = $dbs->dbGetData(null, $table, $join, $where, $val); // implement ORDER BY transactions.date DESC";
        }
        catch(Exception $err)
        {
            $_SESSION['msg'] = "oops! We're experiencing technical issue at the moment";
        }

        if ($data == NULL){?>
           <div class="card text-center">
                <div class="card-header">
                    Transactions
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $rdata['book_name'];?></h5> 
                    <p class="card-text">No transaction found in this book. <br> Log a new transaction in this book to view it.</p>
                    <a href="transaction.php?book=<?php echo $rdata['book_id'].'&type='.$rdata['category_id'];?>" class="btn btn-primary">Log a transaction</a>
                </div>
                <div class="card-footer text-muted">
                    © 2022
                </div>
            </div>
        <?php }
        else{?>
            <div class="card text-center">
                <div class="card-header">
                    Transactions
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $rdata['book_name'];?></h5>
                    <p><?php echo $rdata['category_id'] == 1 ? "Income" : "Expenditure" ;?></p>
                    <p><?php echo $rdata['description'];?></p>
                    <?php
                         $rbook = http_build_query($rdata);
                    ?>
                    <p>
                        <a href="newbook.php?<?php echo $rbook;?>"><button class="btn btn-outline-primary">Edit Book</button></a>
                        <a href="transaction.php?book=<?php echo $rdata['book_id'].'&type='.$rdata['category_id'];?>"><button class="btn btn-outline-success">Log Transaction</button></a>
                        <a href="delete.php?book=<?php echo $rdata['book_id'];?>">
                        <button onclick="return confirm('You\'re trying to delete an entire book. All data and recorded transaction will be deleted, continue?')" 
                        class="btn btn-outline-danger">Delete</button></a>
                    </p>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">S/N</th>
                                <th scope="col">Amount</th>
                                <!-- <th scope="col">Type</th> -->
                                <th scope="col">Category</th>
                                <th scope="col">Description</th>
                                <th scope="col">Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $key => $transaction) {?>
                            <tr>
                                <th scope="row"><?php echo $key+1 ?></th>
                                <td <?php echo $transaction['category_id'] == 2 ? "style='color:red'":" style='color:green'";?>><?php echo "NGN ".$transaction['amount'];?></td>
                                <?php //echo $transaction['type'] == 0 ?"<td style='color:red'>Debit</td>":"<td style='color:green'>Credit</td>";?>
                                <td><?php echo $transaction['name'];?></td>
                                <td><?php echo $transaction['description'];?></td>
                                <td><?php echo $transaction['date'];?></td>
                            
                                <td><span class="btn-group">
                                    <form action="transaction.php" method="post">
                                        <input name="transaction-id" value="<?php echo $transaction['transaction_id'];?>" hidden/>
                                        <input name="sub-category-id" value="<?php echo $transaction['sub_category_id'];?>" hidden/>
                                        <input name="transaction-amount" value="<?php echo $transaction['amount'];?>" hidden/>
                                        <input name="transaction-desc" value="<?php echo $transaction['description'];?>" hidden/>
                                        <input name="book-type" value="<?php echo $rdata['category_id'];?>" hidden/>
                                        <button style="border:1px" class="btn btn-outline-primary" type="submit" name="edit-transaction">Edit</button>
                                    </form>
                                    <form action="delete.php" method="post">
                                        <button onclick="return confirm('You\'re trying to delete a transaction you can\'t recover once deleted, continue?')" 
                                        style="border:1px" class="btn btn-outline-danger" type="submit" name="delete-transaction" value="<?php echo $transaction['transaction_id'];?>">Delete</button>
                                    </form></span>
                                </td>
                            <?php };?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php };
    }
    catch(PDOException $err){
        echo "Can't load transactions: ".$err->getMessage();
    };
}else{
    header("Location: index.php");
};

include_once "template/footer.php";

?>