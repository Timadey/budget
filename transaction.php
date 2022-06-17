<?php
$page_title = "Log Transaction";
include_once "session.php";
include_once "config.php";
include_once "template/header.php";

/**
 * check for log transaction GET data and log transaction in a a particular book
 */

if (isset($_GET['book']) || isset($_GET['type']) ){
    //header("Location: index.php");

    $book_id = clean($_GET['book']);
    $book_type = clean($_GET['type']);
    $sub_categories;

    //check if book exists
    $col = array ("`book_id`");
    $table = "`book`";
    $where = array (
        '`book_id`' => ':bk_id',
        '`category_id`' => ':cat_id',
        '`user_id`' => ':uid'
    );
    $val = array (
        ':bk_id' => $book_id,
        ':cat_id' => $book_type,
        ':uid' => $_SESSION['user_id']
    );

    $book_id = $dbs->dbGetData($col, $table, null, $where, $val);
    if ($book_id == NULL){
        include_once "404.php";
        exit();
    };

    //get all sub category for the current book type

    $col = array ("`sub_category`.`sub_category_id`", "`sub_category`.`name`");
    $table = "`sub_category`";
    $where = array ('`category_id`'=> ':category_id');
    $val = array (':category_id' => $book_type);
    $sub_categories = $dbs->dbGetData($col, $table, null, $where, $val);
    ?>
    <div clas="container h-100">
    <div class="row justify-content-md-center h-100">
        <div class="card">
            <div class="card-header">
                Budget
            </div>
            <?php
                echo isset($_SESSION['msg']) ? 
                "<div class = 'alert alert-danger' role = 'alert'>".$_SESSION['msg']."</div>" : "";
                unset($_SESSION['msg']);
            ?>
            <div class="card-body">
                <h5 class="card-title"><a style="text-decoration:none" href="book.php?book=<?php echo $book_id;?>">View book</a> / Log Transaction</h5>
                
                <form method="POST" action="p/transaction.php" class="my-login-validation" novalidate="">

                <div class="form-group">
                        <input id="book-id" type="" class="form-control" name="book-id" value= "<?php echo $book_id;?>" hidden>
                        <label for="amount">Amount</label>
                        <input id="amount" type="number" class="form-control" name="amount" value= "" required autofocus>
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
    </div>

<?php }
/**
 * check for edit transaction post data and edit transaction
 */
else if (isset($_POST['edit-transaction'])){
    
    // echo "<p>";
    // var_dump($_POST);
    // echo "</p>";

    /**
     * get all post data to edit transaction
     */

    $transaction_id = clean($_POST['transaction-id']);
    $transaction_amount = clean($_POST['transaction-amount']);
    $transaction_desc = clean($_POST['transaction-desc']);
    $book_type = clean($_POST['book-type']);
    $sub_category_id = clean($_POST['sub-category-id']);

    /**
     * get all sub categories for the book type
     */
    $col = array ("`sub_category`.`sub_category_id`", "`sub_category`.`name`");
    $table = "`sub_category`";
    $where = array ('`category_id`'=> ':category_id');
    $val = array (':category_id' => $book_type);
    $sub_categories = $dbs->dbGetData($col, $table, null, $where, $val);
    ?>


    <div clas="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="card">
                <div class="card-header">
                    Edit Transaction
                </div>
                <div class="card-body">
                <h5 class="card-title"><button style="border:1px" class="btn btn-outline-primary" onclick="history.back()">View book</button> </h5>

                <form method="POST" action="p/transaction.php" class="my-login-validation" novalidate="">
                    <input name="transaction-id" value="<?php echo $transaction_id;?>" hidden/>

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input id="amount" type="number" class="form-control" name="amount" value= "<?php echo $transaction_amount;?>" required autofocus>
                    </div><br>

                    <div class="form-group">
                        <label for="sub-category">Categories</label>
                        <select class="form-control" id="sub-category" name="sub-category" required>
                            <?php foreach($sub_categories as $sub_cat => $val){?>
                            <option value="<?php echo $val['sub_category_id'];?>"
                               <?php echo $val['sub_category_id'] == $sub_category_id ? 'selected' : '' ?>
                            ><?php echo $val['name'];?></option>
                            <?php }; ?>
                        </select>
                    </div><br>


                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $transaction_desc;?></textarea>
                    </div><br>
                    <div class="form-group m-0">
                        <button type="submit" id="btn-edit-transaction" name="edit-transaction" class="btn btn-primary btn-block">
                        Edit Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php }
else{
    echo"
    <script>
    history.back();
    </script>
    ";
}; ?>





<?php 
include_once "template/footer.php";
?>