<?php
$page_title = "Add New Book";
include_once "config.php";
//include_once "session.php";
include_once "template/header.php";
?>
<div clas="container h-100">
<div class="row justify-content-md-center h-100">
    <div class="card">
        <div class="card-header">
            Budget
        </div>
        <div class="card-body">
            <h5 class="card-title">Add a new Book</h5>
            
            <form method="POST" action="./p/newbook.php" class="my-login-validation" novalidate="">
                <div class="form-group">
                    <label for="book-name">Book Name</label>
                    <input id="book-name" type="" class="form-control" name="book-name" required autofocus>
                    <div class="invalid-feedback">
                        Book name is needed
                    </div>
                </div><br>

                <div class="form-group">
                    <label for="book-type">Book Type</label>
                    <select class="form-control" id="book-type" name="book-type" >
                        <option value="">Choose...</option>
                        <option value=1>Income</option>
                        <option value=2>Expenditure</option>
                    </select>
                </div><br>
                <div class="form-group">
                    <label for="book-desc">Description</label>
                    <textarea class="form-control" id="book-desc" name="book-desc" rows="3"></textarea>
                </div><br>
                <div class="form-group m-0">
                    <button type="submit" id="add-book-btn" name="add-book" class="btn btn-primary btn-block">
                        Add Book
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