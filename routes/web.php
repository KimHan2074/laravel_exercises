<?php

use App\Http\Controllers\Tong_Controller;
use App\Http\Controllers\Hello_Controller;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NhapSV_Controller;
use App\Http\Controllers\Covid_Controller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ShooperController;
use App\Http\Controllers\TaoBangController;
use App\Http\Controllers\CreateTableController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FetchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ViewErrorBag;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

Route::get('/', function () {
    return view('welcome');
});

Route::GET('/formtong', [Tong_Controller::class,'show_form']) -> name('formtinhtong');
Route::POST('/formtong', [Tong_Controller::class, 'handleCalculator']);

Route::GET('/hello', function(){
    return 'Hello PNV';
});

Route::GET('/khongcoView', [Hello_Controller::class, 'show_hello']);
Route::GET('/coView', [Hello_Controller::class, 'show_hello_view']);
Route::GET('/cobien', [Hello_Controller::class, 'show_hello_cobien']);
Route::GET('/nhieubien', [Hello_Controller::class, 'show']);

Route::GET('/show_form', [Tong_Controller::class, 'show_frm']);

Route::group(['prefix' => 'tutorial'], function()
{
    Route::get('/aws', function() {
        echo "aws tutorial";
    });
    Route::get('/jira', function() {
        echo "jira tutorial";
    });
    Route::get('/testing', function() {
        echo "testing tutorial";
    });
}
);

Route::resource('posts', PostController::class);

Route::get('/nhapSV', [NhapSV_Controller::class, 'show_form']);
Route::post('/nhapSV', [NhapSV_Controller::class, 'handleAddStudent'])->name('handleAddStudent');
Route::get('/getAPI', [Covid_Controller::class, 'getData']);

Route::resource('products', ProductController::class);

Route::get('/showproducts', [ProductsController::class, 'product']);

Route::get('/', [PageController::class, 'getIndex'])->name('home');
Route::get('/type/{id}', [PageController::class, 'getLoaiSp']);	
Route::get('/detail/{id}', [PageController::class, 'getDetail']);			
Route::get('/contact', [PageController::class, 'showContact']);
Route::get('/aboutus', [PageController::class, 'showAboutUs']);
Route::get('/admin', [PageController::class, 'getIndexAdmin']);
Route::get('/admin-add-form', [PageController::class, 'showAdminAdd'])->name('add-product');	
Route::post('/admin-add-form', [PageController::class, 'postAdminAdd']);											
Route::get('/admin-edit-form/{id}', [PageController::class, 'getAdminEdit']);												
Route::post('/admin-edit', [PageController::class, 'postAdminEdit']);
Route::post('/admin-delete/{id}', [PageController::class, 'postAdminDelete']);														
Route::get('search', [PageController::class, 'search']) -> name('search');	

Route::get('/sign-up-form', [UserController::class, 'showSignUpForm'])->name('sign-up');
Route::post('/sign-up-form', [UserController::class, 'register']);
Route::get('/login-form', [UserController::class, 'showLogInForm'])->name('log-in');
Route::post('/login-form', [UserController::class, 'Login']);
Route::get('/logout', [UserController::class, 'Logout']);

Route::get('/homepage', [ShooperController::class, 'getIndex']);


Route::get('/database', function () {
    Schema::create('loaisanpham', function($table) {
        $table->increments('id');
        $table->string('name', 200);

    });
    echo 'Đã thực hiện khởi tạo bảng thành công';
});

Route::get('/database1', [TaoBangController::class, 'createTable']);

Route::get('/database_ban_hang', [CreateTableController::class, 'create_Table']);




Route::get('/products', [FetchController::class, 'index'])->name('products.index');
Route::post('/products', [FetchController::class, 'store'])->name('products.store');
Route::put('/products/{id}', [FetchController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [FetchController::class, 'destroy'])->name('products.destroy');