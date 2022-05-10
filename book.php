<?php
$page_title = "Book";
include_once "config.php";
include_once "template/header.php";

if (isset($_GET['book'])){
    $book_id = trim($_GET['book']);
    //check if book exist
    try{
        $query = "SELECT `book_name`, `book_id`, `category_id`, `description` FROM `books` WHERE books.book_id=:book_id AND books.user_id=:user_id";
        $statement = $dbs->prepare($query);
        $statement->bindValue(':book_id', $book_id);
        $statement->bindValue(':user_id', $uid);
        $statement->execute();
        $rdata = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$rdata){
          include_once "404.php";
          exit();
        };
    }catch(PDOException $err){
        echo "Can't load transactions: ".$err->getMessage();
    };

    try{
        $query = "SELECT * FROM `books`
         INNER JOIN `transactions` USING (`book_id`)
         INNER JOIN `sub_category` USING (`sub_category_id`)
         WHERE books.book_id=:book_id AND books.user_id=:user_id AND sub_category.category_id=:book_type ORDER BY transactions.date DESC";

        // $query = "SELECT * FROM transactions
        //  INNER JOIN books USING (book_id)
        //  WHERE book_id=:book_id AND transactions.user_id=:user_id ORDER BY transactions.date DESC";

        $statement = $dbs->prepare($query);
        $statement->bindValue(':book_id', $book_id);
        $statement->bindValue(':book_type', $rdata['category_id']);
        $statement->bindValue(':user_id', $uid);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        // echo "<p>";
        // var_dump($data);
        // echo "</p>";

        if (!$data){?>
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
                                <th scope="col">Type</th>
                                <th scope="col">Category</th>
                                <th scope="col">Description</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $key => $transaction) {?>
                                <tr>
                                <th scope="row"><?php echo $key+1 ?></th>
                                <td><?php echo "NGN ".$transaction['amount'];?></td>
                                <?php echo $transaction['type'] == 0 ?"<td style='color:red'>Debit</td>":"<td style='color:green'>Credit</td>";?>
                                <td><?php echo $transaction['name'];?></td>
                                <td><?php echo $transaction['description'];?></td>
                                <td><?php echo $transaction['date'];?></td>
                            </tr>
                            <?php };?>
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