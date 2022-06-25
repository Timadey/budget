<?php
namespace app\controllers;

Use app\router\Router;
Use app\helpers\Help;
Use app\models\Book;
Use FFI\Exception;


class BookController
{

        /**
         * index - RenderView for Index page
         * @Router: an nstance of Router class
         */
        public static function index(Router $router)
        {
                try
                {
                        $where = array ('`user_id`' => ':user_id');
                        $value = array (':user_id' => $_SESSION['user_id']);
                        $data = $router->dbs->dbGetData(null, "`books`", null, $where, $value); //implement order by date desc in database class
                }
                catch(\PDOException $err)
                {
                        echo "Failed to load books: ".$err->getMessage();
                };

                echo $router->renderView('index', [
                        'page_title' => 'Index',
                        'data' => $data
                ]);
        }

        /**
         * viewBook - RenderView for Book page
         * @Router: an instance of Router class
         */
        public static function viewBook(Router $router)
        {
                if (isset($_GET['book']))
                {
                        $book_id = Help::clean($_GET['book']);

                        /** check if book exist */
                        $col = array ("`book_name`", "`book_desc`");
                        $table = "`books`";
                        $where = array ('`books`.`book_id`' => ':book_id', '`books`.`user_id`' => ':user_id');
                        $val = array (':book_id' => $book_id, ':user_id' => $_SESSION['user_id']);
                        try
                        {
                                $book = $router->dbs->dbGetData($col, $table, null, $where, $val);
                        }
                        catch(Exception $err)
                        {
                                $_SESSION['msg'] = alert("oops! We're experiencing technical issue at the moment", 0);
                        }
                    
                        if ($book == null){
                                echo $router->renderView("404", ['page_title' => 'Page not found']);
                                exit();
                        };
                        $book = $book[0];

                        $table = "`transactions`";
                        $join = array ('`books`' => '`book_id`', '`sub_category`' => '`sub_category_id`');
                        $where = array ('`books`.`book_id`' => ':book_id', '`books`.`user_id`' => ':user_id');//, '`sub_category`.`category_id`' => ':book_type');
                        $val = array (':book_id' => $book_id, ':user_id' => $_SESSION['user_id']);//, ':book_type' => $rdata['category_id']);
                        try
                        {
                                $transactions = $router->dbs->dbGetData(null, $table, $join, $where, $val); // implement ORDER BY transactions.date DESC";
                        }
                        catch(Exception $err)
                        {
                                $_SESSION['msg'] = alert("oops! We're experiencing technical issue at the moment", 0);
                        };

                        echo $router->renderView('book/view_book',
                        [
                                'page_title' => $book['book_name'],
                                'book_id' => $book_id,
                                'transactions' => $transactions,
                                'book' => $book
                        ]);
                }
                else
                {
                        header("Location: /");
                };
        }
        /**
         * addBook - RenderView for Book page
         * @Router: an instance of Router class
         */
        public static function updateBook(Router $router)
        {
                $edit = false;
                if (isset($_GET['book_name']) && isset($_GET['book_id']) && isset($_GET['book_desc']))
                {
                        $book_name = Help::clean($_GET['book_name']);
                        $book_id = Help::clean($_GET['book_id']);
                        $book_desc = Help::clean($_GET['book_desc']);
                        $edit = "Edit ".$book_name;

                        /** check if book exist */
                        $col = array ("`book_name`", "`book_desc`");
                        $table = "`books`";
                        $where = array ('`books`.`book_id`' => ':book_id', '`books`.`user_id`' => ':user_id');
                        $val = array (':book_id' => $book_id, ':user_id' => $_SESSION['user_id']);
                        try
                        {
                                $book = $router->dbs->dbGetData($col, $table, null, $where, $val);
                        }
                        catch(Exception $err)
                        {
                                $_SESSION['msg'] = alert("oops! We're experiencing technical issue at the moment", 0);
                        }
                    
                        if ($book == null){
                                echo $router->renderView("404", ['page_title' => 'Page not found']);
                                exit;
                        };
                }
               
                echo $router->renderView('book/update_book', [
                        'page_title' => $edit ?:'Add New Book',
                        'edit' => $edit ?: 'Add New Book',
                        'view_book' => $edit ? '/book?book='.$book_id : '/',
                        'form_action' => $edit ? '/book/edit' : '/book/add',
                        'error' => $error??null,
                        'book_id' => $edit ? $book_id : '',
                        'book_name' => $edit ? $book_name : '',
                        'book_desc' => $edit ? $book_desc : '',
                        'button_id' => $edit ? 'btn-edit-book' : 'btn-add-book',
                        'button_name' => $edit ? 'edit-book' : 'add-book',
                        'button_label' => $edit ? 'Edit Book' : 'Add Book'
                ]);
        }
        public static function addBook(Router $router)
        {
                if (isset($_POST['add-book']))
                {
                        $book_name = Help::clean($_POST['book-name']);
                        $book_desc = Help::clean($_POST['book-desc']);

                        $book = new Book($router->dbs, [
                                'user_id' => $_SESSION['user_id'],
                                'book_name' => $book_name,
                                'book_desc' => $book_desc
                        ]);
                        $error = $book->addNewBook();
                        
                        if (is_int($error))
                        {
                                header("Location: /book?book=$error");
                                exit;
                        }
                        if ($error === null)
                        $error[] = "Oops! We're experencing technical issues";

                }
                echo $router->renderView('book/update_book', [
                        'page_title' => 'Add New Book',
                        'edit' => 'Add New Book',
                        'view_book' => '/',
                        'form_action' => '/book/add',
                        'error' => $error??null,
                        'book_id' => '',
                        'book_name' => $book_name,
                        'book_desc' =>$book_desc,
                        'button_id' => 'btn-add-book',
                        'button_name' => 'add-book',
                        'button_label' => 'Add Book'
                ]);
        }
}
?>