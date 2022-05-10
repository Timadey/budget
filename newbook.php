<?php
$page_title = "Add New Book";
include_once "config.php";
//include_once "session.php";
include_once "template/header.php";

$edit = false;
$book_name = "";
$book_type = "";
$book_id = "";
$book_desc = "";
if (isset($_GET['book_name']) && isset($_GET['book_id']) && isset($_GET['category_id']) && isset($_GET['description'])){
    $edit = true;
    $book_name = $_GET['book_name'];
    $book_type = $_GET['category_id'];
    $book_id = $_GET['book_id'];
    $book_desc = $_GET['description'];
};
?>
<div clas="container h-100">
<div class="row justify-content-md-center h-100">
    <div class="card">
        <div class="card-header">
            Budget
        </div>
        <div class="card-body">
            <h5 class="card-title"><a style="text-decoration:none" href="index.php">View books</a> / <?php echo $edit?'Edit '.$book_name:'Add a New book';?></h5>
            
            <form method="POST" action="./p/newbook.php" class="my-login-validation" novalidate="">
                <div class="form-group">
                    <input id="book-id" type="" class="form-control" name="book-id" value= "<?php echo $edit ? $book_id:'';?>" hidden>
                    <label for="book-name">Book Name</label>
                    <input id="book-name" type="" class="form-control" name="book-name" value= "<?php echo $edit ? $book_name:'';?>" required autofocus>
                    <div class="invalid-feedback">
                        Book name is needed
                    </div>
                </div><br>

                <div class="form-group">
                    <label for="book-type">Book Type</label>
                    <select class="form-control" id="book-type" name="book-type" <?php echo $edit ? 'disabled':'';?> required>
                        <option value="">Choose...</option>
                        <option value=1 <?php echo $book_type == 1 ? 'selected':'';?>>Income</option>
                        <option value=2 <?php echo $book_type == 2 ? 'selected':'';?>>Expenditure</option>
                    </select>
                </div><br>
                <div class="form-group">
                    <label for="book-desc">Description</label>
                    <textarea class="form-control" id="book-desc" name="book-desc" rows="3" required><?php echo $edit ? $book_desc:'';?></textarea>
                </div><br>
                <div class="form-group m-0">
                    <button type="submit" id="<?php echo $edit ? 'btn-edit-book':'btn-add-book';?>" name="<?php echo $edit ? 'edit-book':'add-book';?>" class="btn btn-primary btn-block">
                    <?php echo $edit ? 'Edit Book':'Add Book';?>
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