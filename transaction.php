<?php
$page_title = "Log Transaction";
include_once "session.php";
include_once "config.php";
include_once "template/header.php";

/**
 * check for log transaction GET data and log transaction in a a particular book
 */

if (isset($_GET['book']) && !isset($_GET['cat']))// || isset($_GET['type']) )
{
    //header("Location: index.php");

    $book_id = clean($_GET['book']);
    //$book_type = clean($_GET['type']);
    $sub_categories;

    //check if book exists
    $col = array ("`book_name`");
    $table = "`books`";
    $where = array (
        '`book_id`' => ':bk_id',
        '`user_id`' => ':uid'
    );
    $val = array (
        ':bk_id' => $book_id,
        ':uid' => $_SESSION['user_id']
    );

    $book = $dbs->dbGetData($col, $table, null, $where, $val);
    $book = $book[0];
    if ($book == NULL){
        include_once "404.php";
        exit();
    };
    ?>
    <div class='card-deck'>
        <div class="card text-white bg-success mb-3" style="max-width: 18rem;" >
            <div class="card-header">Log Transactions</div>
            <div class="card-body">
                <h5 class="card-title"><?php echo $book['book_name'];?>'s Income</h5>
                <p class="card-text">Record income and daily inflow of cash into your account.</p>
                <a href="transaction.php?book=<?php echo $book_id.'&cat=1';?>" class="btn btn-outline-light btn-block">Log Income</a>
            </div>
        </div>

        <div class="card text-white bg-danger mb-3" style="max-width: 18rem;" onclick="location.href = 'transaction.php?book=<?php echo $book_id.'&cat=2';?>">
        <div class="card-header">Log Transactions</div>
            <div class="card-body">
                <h5 class="card-title"> <?php echo $book['book_name'];?>'s Expenditure</h5>
                <p class="card-text">Track how deep you're eating your money away.</p>
                <a href="transaction.php?book=<?php echo $book_id.'&cat=2';?>" class="btn btn-outline-light">Log Expenditure</a>
            </div>
        </div>
    </div>
    <?php unset($_GET); 
}
elseif (isset($_GET['book']) && isset($_GET['cat']))
{
    $book_id = clean($_GET['book']);
    $cat = clean($_GET['cat']);

    //check if book exists
    $col = array ("`book_name`");
    $table = "`books`";
    $where = array (
        '`book_id`' => ':bk_id',
        '`user_id`' => ':uid'
    );
    $val = array (
        ':bk_id' => $book_id,
        ':uid' => $_SESSION['user_id']
    );

    $book = $dbs->dbGetData($col, $table, null, $where, $val);
    $book = $book[0];
    if ($book == NULL){
        include_once "404.php";
        exit();
    };

    //check if cat
    $col = ["`category_name`"];
    $table = "`category`";
    $where = ['`category_id`' => ':cat_id'];
    $val = [':cat_id' => $cat];

    $cat_name = $dbs->dbGetData($col, $table, null, $where, $val);
    $cat_name = $cat_name[0];
    if ($cat_name == NULL){
        include_once "404.php";
        exit();
    };

    //get all sub category for the current category
    $col = array ("`sub_category`.`sub_category_id`", "`sub_category`.`sub_category_name`");
    $table = "`sub_category`";
    $where = array ('`category_id`'=> ':category_id');
    $val = array (':category_id' => $cat);
    $sub_categories = $dbs->dbGetData($col, $table, null, $where, $val);
    ?>

    <div clas="container h-100">
    <div class="row justify-content-md-center h-100">
        <div class="card">
            <div class="card-header">
            <?php echo $book['book_name'];?>
            </div>
            <?php
               echo isset($_SESSION['msg']) ? $_SESSION['msg'] : "";
                unset($_SESSION['msg']);
            ?>
            <div class="card-body">
                <h5 class="card-title"><a style="text-decoration:none" href="book.php?book=<?php echo $book_id;?>">View book</a> / <?php echo  'Log '.$cat_name['category_name'];?></h5>
                
                <form method="POST" action="p/transaction.php" class="my-login-validation" novalidate="">

                <div class="form-group">
                        <input id="book-id" type="" class="form-control" name="book-id" value= "<?php echo $book_id;?>" hidden>
                        <input id="book-id" type="" class="form-control" name="category-id" value= "<?php echo $cat;?>" hidden>
                        <label for="amount">Amount</label>
                        <input id="amount" type="number" class="form-control" name="amount" value= "" required autofocus>
                    </div><br>

                    <div class="form-group">
                        <label for="sub-category">Categories</label>
                        <select class="form-control" id="sub-category" name="sub-category" required>
                            <option value="">Choose...</option>
                            <?php foreach($sub_categories as $sub_cat => $val){?>
                            <option value=<?php echo $val['sub_category_id'];?>><?php echo $val['sub_category_name'];?></option>
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
    
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";
   

    /**
     * get all post data to edit transaction
     */
    $book_id = clean($_POST['book-id']);
    $transaction_id = clean($_POST['transaction-id']);
    $transaction_amount = clean($_POST['transaction-amount']);
    $transaction_desc = clean($_POST['transaction-desc']);
    $category_id = clean($_POST['category-id']);
    $sub_category_id = clean($_POST['sub-category-id']);

    /**
     * validate this inputs
     */

     /**
      * confirm this transaction belongs to this book and this user
      */
      $val = [':bk_id' => $book_id, ':trans_id' => $transaction_id, ':uid' => $_SESSION['user_id']];
      $tran_exist = $dbs->dbGetData(['`transaction_id`'], '`transactions`', null, 
      ['book_id' => ':bk_id', 'transaction_id' =>':trans_id', 'user_id' => ':uid'], $val);

      /**
      * confirm this category id exist and it corresponding sub category
      */
      $val = [':sub_id' => $sub_category_id, ':cat_id' => $category_id];
      $cat_exist = $dbs->dbGetData(['`sub_category_id`'], '`sub_category`', null,
      ['sub_category_id' => ':sub_id', 'category_id' =>':cat_id'], $val);

      if ($tran_exist == null || $cat_exist == null)
      {
        include_once "404.php";
        exit();
      }
      //exit;
      //get all sub category for the current category
      $col = array ("`sub_category`.`sub_category_id`", "`sub_category`.`sub_category_name`");
      $table = "`sub_category`";
      $where = array ('`category_id`'=> ':category_id');
      $val = array (':category_id' => $category_id);  
      $sub_categories = $dbs->dbGetData($col, $table, null, $where, $val);
    ?>


    <div clas="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="card">
                <div class="card-header">
                    Edit Transaction
                </div>
                <div class="card-body">
                <h5 class="card-title"><a style="text-decoration:none" href="book.php?book=<?php echo $book_id;?>">View book</a> </h5>

                <form method="POST" action="p/transaction.php" class="my-login-validation" novalidate="">
                    <input name="transaction-id" value="<?php echo $transaction_id;?>" hidden/>

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input id="amount" type="number" class="form-control" name="amount" value= "<?php echo $transaction_amount;?>" required autofocus>
                    </div><br>

                    <div class="form-group">
                        <label for="sub-category">Category</label>
                        <select class="form-control" id="sub-category" name="sub-category" required>
                            <?php foreach($sub_categories as $sub_cat => $val){?>
                            <option value="<?php echo $val['sub_category_id'];?>"
                               <?php echo $val['sub_category_id'] == $sub_category_id ? 'selected' : '' ?>
                            ><?php echo $val['sub_category_name'];?></option>
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