<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\ECommerceController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\Report;
use App\Http\Controllers\TrucksController;

Route::get('/', [ECommerceController::class, 'index'])->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'permission:dashboard_access'])
    ->name('admin.dashboard');

Route::get('/test', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('test');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/forms', function () {
        return view('admin.forms');
    })->name('admin.forms');
    Route::get('/tables', function () {
        return view('admin.tables');
    })->name('admin.tables');
    Route::get('/ui-elements', function () {
        return view('admin.ui-elements');
    })->name('admin.ui-elements');
});

// Route::group(['middleware' => ['permission:publish articles']], function () {});

// Group routes that need admin role and authentication
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Akses khusus role:admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('product', ProductController::class);
        Route::resource('sales', SalesController::class);
        Route::delete('sales/cancel/{sale}', [SalesController::class, 'cancel'])->name('sales.cancel');
        Route::put('/sales/confirmation/{sale}', [SalesController::class, 'payment_confirmation'])->name('sales.confirm_payment');

        Route::resource('customers', CustomerController::class);
        Route::resource('employees', EmployeeController::class);
        Route::resource('finance', FinanceController::class);
        Route::resource('trucks', TrucksController::class);
        Route::resource('orders', OrderController::class);

        // Orders
        Route::get('orders/assign/worker/{order}', [OrderController::class, 'assignWorkerView'])->name('orders.assignWorkerView');
        Route::put('orders/assign/worker/{order}', [OrderController::class, 'assignWorker'])->name('orders.assignWorker');
        Route::get('orders/{order}/assign-delivery', [OrderController::class, 'assignDeliveryForm'])->name('orders.assign_delivery_form');
        Route::post('orders/{order}/assign-delivery', [OrderController::class, 'assignDelivery'])->name('orders.assign_delivery');
        Route::put('orders/{order}/complete', [OrderController::class, 'markAsCompleted'])->name('orders.complete');
    });

    // Akses role:admin atau owner
    Route::middleware('role:admin|owner')->group(function () {
        Route::prefix('laporan')->group(function () {
            Route::get('/finance', [Report::class, 'indexFinance'])->name('report_finance.index');
            Route::get('/finance/{source}', [Report::class, 'showFinance'])->name('report_finance.show');
            Route::get('/finance/{source}/print', [Report::class, 'printFinance'])->name('report_finance.print');

            Route::get('/sales', [Report::class, 'indexSales'])->name('report_sales.index');
            Route::get('/sales/print', [Report::class, 'printSales'])->name('report_sales.print');

            Route::get('/best_sellers', [Report::class, 'indexBestSellingProducts'])->name('report_best_sellers.index');
            Route::get('/best_sellers/print', [Report::class, 'printBestSellingProducts'])->name('report_best_sellers.print');

            Route::get('/low_stock', [Report::class, 'indexLowStock'])->name('report_low_stock.index');
            Route::get('/low_stock/print', [Report::class, 'printLowStock'])->name('report_low_stock.print');
        });
    });
});

Route::prefix('customer')->name('customer.')->middleware(['auth'])->group(
    function () {
        Route::get('/cart', [ECommerceController::class, 'cartIndex'])->name('cart.index');        
        Route::post('/cart/add', [ECommerceController::class, 'add'])->name('cart.add');
        Route::put('/cart/update/{id}', [ECommerceController::class, 'update'])->name('cart.update');
        Route::delete('/cart/delete/{id}', [ECommerceController::class, 'destroy'])->name('cart.delete');
        Route::post('/cart/checkout', [ECommerceController::class, 'checkout'])->name('cart.checkout');

        Route::get('/orders', [ECommerceController::class, 'cart'])->name('orders.index');
    }
);

require __DIR__ . '/auth.php';
