<?php

use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\SpecializationController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.index');
    Route::resource('roles', RoleController::class)->names('admin.roles');
    Route::resource('users', UserController::class)->names('admin.users');
    Route::resource('permissions', PermissionController::class)->names('admin.permissions');
    Route::resource('categories', CategoryController::class)->names('admin.categories');
    
    // Product images routes must be defined before resource routes
    Route::delete('products/{product}/images/{image}', [ProductController::class, 'destroyImage'])->name('admin.products.images.destroy');
    Route::resource('products', ProductController::class)->names('admin.products');
    
    Route::resource('countries', CountryController::class)->names('admin.countries')->except(['show']);
    Route::resource('specializations', SpecializationController::class)->names('admin.specializations')->except(['show']);
    Route::get('orders/', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::post('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    // Settings
    Route::get('settings', [AdminSettingController::class, 'edit'])->name('admin.settings.edit');
    Route::put('settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');

});
