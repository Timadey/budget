<?php
$page_title = "Home";
include_once "session.php";
include_once "config.php";
include_once "template/header.php";


try{
    $query = "SELECT * FROM `books` INNER JOIN `category` USING (`category_id`) WHERE `user_id`=:user_id ORDER BY `date` DESC";
    $statement = $dbs->conn->prepare($query);
    $statement->bindValue(':user_id', $user->getUid());
    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    
}catch(PDOException $err){
    echo "Failed to load books: ".$err->getMessage();
};


if ($data){
    //load all books
    // echo "<p>";
    // var_dump($data);
    // echo "</p>"; ?>
    <div class="card text-center">
        <div class="card-header">
            Budget
        </div>
        <div class="card-body">
            <h5 class="card-title">Income and Expenditure</h5>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">S/N</th>
                        <th scope="col">Book Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Date Added</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $key => $value) {?>
                    <tr>
                        <th scope="row"><?php echo $key + 1 ?></th>
                        <td><a style="text-decoration:none" href="book.php?book=<?php echo $value['book_id'];?>"><?php echo $value['book_name'];?></a></td>
                        <td><?php echo $value['category_name'];?></td>
                        <td><?php echo $value['date'];?></td>
                    </tr>

                <?php };?>
                    
                </tbody>
            </table>
        </div>
        <!-- <div class="card-footer text-muted">
            © 2022
        </div> -->
    </div>
<?php }else{?>
    <div class="card text-center">
        <div class="card-header">
            Budget
        </div>
        <div class="card-body">
            <h5 class="card-title">Income and Expenditure</h5>
            <p class="card-text">Record and keep tracks of your expensese. <br> Open <em>a new book</em> to start using <b>Budget</b></p>
            <a href="newbook.php" class="btn btn-primary">Open a New Book</a>
        </div>
        <div class="card-footer text-muted">
            © 2022
        </div>
    </div>
        
<?php }
?>

    
<?php
// echo "<p>";
// var_dump($_SESSION);
// echo "</p>";
include_once "template/footer.php";

?>