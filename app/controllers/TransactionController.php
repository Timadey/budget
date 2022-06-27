<?php
namespace app\controllers;

Use app\router\Router;
Use app\helpers\Help;
Use app\models\Book;
Use app\models\Transaction;
Use FFI\Exception;


class TransactionController
{
        public static function addTransaction(Router $router)
        {
                if (isset($_GET['book']) && !isset($_GET['cat']))
                {
                        $book_id = Help::clean($_GET['book']);
                        $book = new Book ($router->dbs, ['book_id' => $book_id, 'user_id' => $_SESSION['user_id']]);
                        $exist= $book->idExist();
                        if (!$exist)
                        {
                                $_SESSION['msg'] = Help::alert("That book does not exist", 0);
                                echo header("Location: /");
                        }
                        
                        echo $router->renderView('transaction/transaction_type', [
                                'page_title' => 'Edit '.$exist['book_name'],
                                'book' => $exist,
                                'book_id' =>$book_id
                        ]); exit;
                }
                elseif (isset($_GET['book']) && isset($_GET['cat']))
                {
                        $book_id = Help::clean($_GET['book']);
                        $category_id = Help::clean($_GET['cat']);

                        /** check if book exist */
                        $book = new Book ($router->dbs, ['book_id' => $book_id, 'user_id' => $_SESSION['user_id']]);
                        $exist= $book->idExist();
                        if (!$exist)
                        {
                                $_SESSION['msg'] = Help::alert("That book does not exist", 0);
                                echo header("Location: /");
                        }

                        /** check if category exist */
                        $cat_name = $router->dbs->dbGetData(["`category_name`"], "`category`", null, ['`category_id`' => ':cat_id'], [':cat_id' => $category_id]);
                        $cat_name = $cat_name[0]['category_name'];
                        if ($cat_name == NULL)
                        {
                                $_SESSION['msg'] = Help::alert("That category does not exist", 0);
                                echo header("Location: /book?book=$book_id");
                        };

                        /** get all sub category for the current category */
                        $sub_categories = $router->dbs->dbGetData(["`sub_category`.`sub_category_id`", "`sub_category`.`sub_category_name`"],
                        "`sub_category`", null, ['`category_id`'=> ':category_id'], [':category_id' => $category_id]);
                }
                else if (isset($_POST['log-transaction']))
                {
                        $book_id = Help::clean($_POST['book-id']);
                        $amount = Help::clean($_POST['amount']);
                        $sub_category_id = Help::clean($_POST['sub-category']);
                        $desc = Help::clean($_POST['description']);
                        $category_id = Help::clean($_POST['category-id']);

                        

                        /**
                         * confirm this category id exist and it corresponding sub category
                        */
                        $sub_categories = $router->dbs->dbGetData(['`sub_category_id`', '`sub_category_name`'], '`sub_category`', null,
                        ['category_id' =>':cat_id'], [':cat_id' => $category_id]);

                        if (!$sub_categories)
                        {
                                $_SESSION['msg'] = Help::alert("That category doesn't exist", 0);
                                echo header("Location: /");
                        }

                        $transaction = new Transaction($router->dbs, [
                                'user_id' => $_SESSION['user_id'],
                                'book_id' => $book_id,
                                'sub_category_id' => $sub_category_id,
                                'transaction_amount' => $amount,
                                'transaction_desc' => $desc
                        ]);
                        $error = $transaction->addTransaction();

                        if (is_array($error))
                        {
                                /** check if category exist */
                                $cat_name = $router->dbs->dbGetData(["`category_name`"], "`category`", null, ['`category_id`' => ':cat_id'], [':cat_id' => $category_id]);
                                $cat_name = $cat_name[0]['category_name'];
                                if ($cat_name == NULL)
                                {
                                        $_SESSION['msg'] = Help::alert("That category does not exist", 0);
                                        echo header("Location: /book?book=$book_id");
                                }
                                
                        }
                        else echo header("Location: /book?book=$book_id"); 

                       
                }
                echo $router->renderView('transaction/update_transaction', [
                        'page_title' => $page_title?? 'Add New Transaction',
                        'error' => $error ?? '',
                        'cat' => $category_id,
                        'cat_name' => $cat_name ?? 'Transaction',
                        'transaction_id' => $transaction_id ?? '',
                        'transaction_amount' => $transaction_amount ?? '',
                        'transaction_desc' => $transaction_desc ?? '',
                        'book' => $exist ?? ['book_name' => 'Transaction'],
                        'book_id' => $book_id,
                        'sub_categories' => $sub_categories,
                        'button_label' => "Log $cat_name",
                        'button_id' => 'btn-log-transaction',
                        'button_name' => 'log-transaction'
                ]);
                

                

                        
        }
}



//
?>