<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MobileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SaleMasterController;
use App\Http\Controllers\SaleDetailController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontController;
use App\Models\SaleDetail;
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


//one-to-one relationship
Route::get('add-customer', [CustomerController::class, 'add_customer']);
Route::get('show-mobile/{id}', [CustomerController::class, 'show_mobile']);
Route::get('show-customer/{id}', [MobileController::class, 'show_customer']);

//one-to-many relationship
Route::get('add-post', [PostController::class, 'addPost']);
Route::get('add-comment/{id}', [PostController::class, 'addComment']);
Route::get('get-comments/{id}', [PostController::class, 'getCommentsByPost']);

//Many-to-many relationship
Route::get('add-roles', [RoleController::class, 'addRole']);
Route::get('add-users', [RoleController::class, 'addUser']);
Route::get('usersByRole/{id}', [RoleController::class, 'getAllUsersByRole']);
Route::get('rolesByUser/{id}', [RoleController::class, 'getAllRolesByUser']);


Auth::routes();

Route::resource('products', ProductController::class)->middleware('CustomAuth');
Route::resource('categories', CategoryController::class)->middleware('CustomAuth');
Route::resource('items', ItemController::class)->middleware('CustomAuth');
Route::resource('customers', CustomerController::class)->middleware('CustomAuth');
Route::resource('vendors', VendorController::class)->middleware('CustomAuth');
Route::resource('salemasters', SaleMasterController::class)->middleware('CustomAuth');
// Route::resource('saledetails', SaleDetailController::class);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('CustomAuth')->name('home');
Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');
Route::get('home', [FrontController::class, 'home'])->name('home');
Route::get('about-us', [FrontController::class, 'aboutUs'])->name('about.us');


Route::get('saledetails', [SaleDetailController::class, 'index']);
Route::post('saledetails', [SaleDetailController::class, 'store']);
