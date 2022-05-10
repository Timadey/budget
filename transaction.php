<?php
$page_title = "Log Transaction";
include_once "config.php";
include_once "template/header.php";

if (!isset($_GET['book']) ||!isset($_GET['type']) ){
    header("Location: index.php");
};
$book_id = trim($_GET['book']);
$book_type = trim($_GET['type']);
$sub_categories;

//check get
$query = "SELECT book_id FROM books WHERE book_id=:book_id AND category_id=:book_type AND user_id=:user_id";
$statement = $dbs->prepare($query);
$statement->bindValue(':book_id', $book_id);
$statement->bindValue(':book_type', $book_type);
$statement->bindValue(':user_id', $uid);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
if (!$data){
    include_once "404.php";
    exit();
};

//get all sub category for the current book type
$query = "SELECT `sub_category`.`sub_category_id`, `sub_category`.`name`
FROM `sub_category`
WHERE `category_id`=:category_id";

$statement = $dbs->prepare($query);
$statement->bindValue(':category_id', $book_type);
$statement->execute();
$sub_categories = $statement->fetchAll(PDO::FETCH_ASSOC);

// echo "<p>";
// var_dump($sub_categories);
// echo "</p>";
?>
<div clas="container h-100">
<div class="row justify-content-md-center h-100">
    <div class="card">
        <div class="card-header">
            Budget
        </div>
        <div class="card-body">
            <h5 class="card-title"><a style="text-decoration:none" href="book.php?book=<?php echo $book_id;?>">View book</a> / Log Transaction</h5>
            
            <form method="POST" action="p/transaction.php" class="my-login-validation" novalidate="">

            <div class="form-group">
                    <input id="book-id" type="" class="form-control" name="book-id" value= "<?php echo $book_id;?>" hidden>
                    <label for="amount">Amount</label>
                    <input id="amount" type="number" class="form-control" name="amount" value= "" required autofocus>
                </div><br>

                <div class="form-group">
                    <label for="type">Type</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="">Choose...</option>
                        <option value=0 >Debit</option>
                        <option value=1 >Credit</option>
                    </select>
                </div><br>

                <div class="form-group">
                    <label for="sub-category">Categories</label>
                    <select class="form-control" id="sub-category" name="sub-category" required>
                        <option value="">Choose...</option>
                        <?php foreach($sub_categories as $sub_cat => $val){?>
                        <option value=<?php echo $val['sub_category_id'];?>><?php echo $val['name'];?></option>
                        <?php }; ?>
                    </select>
                </div><br>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div><br>
                <div class="form-group m-0">
                    <button type="submit" id="btn-log-transaction" name="log-transaction" class="btn btn-primary btn-block">
                    Log Transaction
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
        <!-- <div class="card-footer text-muted">
            © 2022
        </div> -->
    <!-- </div> -->
</div>


<?php 
include_once "template/footer.php";
?>