<?php
session_start();
$_SESSION['user_id'] = 6;
$_SESSION['email'] = 'tim@budget.com';
$_SESSION['name'] = "Timothy";

require_once __DIR__.'/../config/config.php';
require_once __DIR__.'/../vendor/autoload.php';

use app\router\Router;
use app\controllers\BookController;
use app\operations\Database;
use app\operations\Account;

$dbs = new Database();
$dbs->dbConnect($DB_HOST,$DB_USER, $DB_PASSWORD, $DB_NAME);
$user = new Account ($dbs);

$router = new Router($dbs);
$router->get('/', [BookController::class, 'index']);
$router->get('/book', [BookController::class, 'viewBook']);
$router->get('/book/add', [BookController::class, 'updateBook']);
$router->post('/book/add', [BookController::class, 'addBook']);
$router->get('/book/edit', [BookController::class, 'updateBook']);
$router->get('/transaction/edit', [TransactionController::class, 'editTransaction']);
$router->get('/transaction/add', [TransactionController::class, 'addTransaction']);
$router->resolve();
?>