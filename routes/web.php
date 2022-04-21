<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontController;
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
    return view('welcome');
});
// Route::get('add-category', [CategoryController::class, 'add_category'])->name('add_category');
// Route::get('add-product/{id}', [ProductController::class, 'add_product'])->name('add_product');

Auth::routes();

Route::resource('products', ProductController::class)->middleware('CustomAuth');
Route::resource('categories', CategoryController::class)->middleware('CustomAuth');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('CustomAuth')->name('home');
Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');
Route::get('home', [FrontController::class, 'home'])->name('home');
// Route::get('products', [FrontController::class, 'products'])->name('products.index');
Route::get('about-us', [FrontController::class, 'aboutUs'])->name('about.us');
