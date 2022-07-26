<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('shiped.home');
});

Auth::routes();

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/account', [AccountController::class, 'index'])->name('account.index');
Route::get('/account/create', [AccountController::class, 'create'])->name('account.create');
Route::post('/account', [AccountController::class, 'store'])->name('account.store');
Route::get('/account/{account}', [AccountController::class, 'show'])->name('account.show');
Route::get('/account/{account}/edit', [AccountController::class, 'edit'])->name('account.edit');
Route::patch('/account/{account}', [AccountController::class, 'update'])->name('account.update');


Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
Route::get('/transaction/create/{account}/{category}', [TransactionController::class, 'create'])->name('transaction.create');
Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.store');

Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category', [CategoryController::class, 'store'])->name('category.store');

Route::get('/subcategory/create', [SubCategoryController::class, 'create'])->name('subcategory.create');
Route::post('/subcategory', [SubCategoryController::class, 'store'])->name('subcategory.store');

?>