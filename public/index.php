<?php
session_start();
$_SESSION['user_id'] = 6;
$_SESSION['email'] = 'tim@budget.com';
$_SESSION['name'] = "Timothy";
require_once __DIR__.'/../vendor/autoload.php';

use app\router\Router;
use app\controllers\BookController;
use app\Database;
use app\Account;

//connect to database
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASSWORD = '';
$DB_NAME ='budget';

$dbs = new Database($DB_HOST,$DB_USER, $DB_PASSWORD, $DB_NAME);
$dbs->dbConnect();
$user = new Account ($dbs);

$router = new Router($dbs);
$router->get('/', [BookController::class, 'index']);
$router->get('/book', [BookController::class, 'viewBook']);
$router->get('/book/add', [BookController::class, 'addBook']);
$router->get('/book/edit', [BookController::class, 'editBook']);
$router->get('/transaction/edit', [TransactionController::class, 'editTransaction']);
$router->get('/transaction/add', [TransactionController::class, 'addTransaction']);
$router->resolve();
?>