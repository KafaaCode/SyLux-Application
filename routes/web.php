<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/users', function () {
    return view('users.index');
})->middleware('auth')->name('users.index');

Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');


Route::get('user-create', [UserController::class, 'create_user']);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/privacy', function () {
    return view('front.privacy.privacy');
})->name('privacy');
Route::get('/contact', function () {
    return view('front.contact.contact');
})->name('contact');
Route::get('/about', function () {
    return view('front.about.about');
})->name('about');

Route::post('/contact', [SupportController::class, 'storeWeb'])->name('support.store');



// Language routes
Route::get('/language/{locale}', [LanguageController::class, 'switchLanguage'])->name('language.switch');
Route::get('/api/language/current', [LanguageController::class, 'getCurrentLanguage'])->name('language.current');

// Cart routes

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/orders', [OrderController::class, 'indexFront'])->middleware('auth')->name('orders.index');
Route::post('/orders', [OrderController::class, 'storeWeb'])->middleware('auth')->name('orders.store');

Route::get('/categories', [CategoryController::class, 'webIndex'])->name('categories.web.index');
Route::get('/categories/{category}', [CategoryController::class, 'webshow'])->name('categories.web.show');
Route::get('/products', [ProductController::class, 'webIndex'])->name('products.web.index');
Route::get('/products/{product}', [ProductController::class, 'webShow'])->name('products.web.show');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
