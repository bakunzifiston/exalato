<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\InventoryRecordController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'create'])->name('login');
        Route::post('login', [LoginController::class, 'store'])->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::post('products/bulk-destroy', [ProductController::class, 'bulkDestroy'])->name('products.bulk-destroy');
        Route::resource('products', ProductController::class);

        Route::post('employees/bulk-destroy', [EmployeeController::class, 'bulkDestroy'])->name('employees.bulk-destroy');
        Route::resource('employees', EmployeeController::class);

        Route::post('productions/bulk-destroy', [ProductionController::class, 'bulkDestroy'])->name('productions.bulk-destroy');
        Route::resource('productions', ProductionController::class);

        Route::post('inventory-records/bulk-destroy', [InventoryRecordController::class, 'bulkDestroy'])->name('inventory-records.bulk-destroy');
        Route::resource('inventory-records', InventoryRecordController::class);

        Route::post('sales/bulk-destroy', [SaleController::class, 'bulkDestroy'])->name('sales.bulk-destroy');
        Route::resource('sales', SaleController::class);

        Route::post('users/bulk-destroy', [UserController::class, 'bulkDestroy'])->name('users.bulk-destroy');
        Route::resource('users', UserController::class);
    });
});
