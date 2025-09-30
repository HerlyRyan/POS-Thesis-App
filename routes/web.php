<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\DashboardController;
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
use App\Http\Controllers\Admin\OrderPaymentController;
use App\Http\Controllers\Admin\PayableController;
use App\Http\Controllers\Admin\ReceivableController;
use App\Http\Controllers\Admin\SalesTargetController;
use App\Http\Controllers\Report;
use App\Http\Controllers\TrucksController;

Route::get('/', [ECommerceController::class, 'index'])->name('welcome');
Route::get('/about', function () {
    return view('customer.about');
})->name('about');
Route::get('/contact', function () {
    return view('customer.contact');
})->name('contact');
Route::get('/products/index', [ECommerceController::class, 'productIndex'])->name('products.index');
Route::get('/product/{id}', [ECommerceController::class, 'productShow'])->name('products.show');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'permission:dashboard_access'])
    ->name('dashboard');

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

Route::get('/driver/tracking/{truckId}', function ($truckId) {
    return view('admin.trucks.driver', ['truckId' => $truckId]);
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
        Route::get('product/update-stock/view', [ProductController::class, 'update_stock_view'])->name('product.update-stock-view');
        Route::put('product/update-stock/process', [ProductController::class, 'update_stock'])->name('product.update-stock');
        Route::resource('sales', SalesController::class);
        Route::delete('sales/cancel/{sale}', [SalesController::class, 'cancel'])->name('sales.cancel');
        Route::put('/sales/confirmation/{sale}', [SalesController::class, 'payment_confirmation'])->name('sales.confirm_payment');
        Route::put('/sales/cod/{sale}', [SalesController::class, 'cod_confirmation'])->name('sales.cod_payment');
        Route::get('/sales/print-invoice/{sale}', [SalesController::class, 'printInvoice'])->name('sales.print-invoice');

        Route::resource('customers', CustomerController::class);
        Route::resource('employees', EmployeeController::class);
        Route::resource('finance', FinanceController::class);
        Route::resource('trucks', TrucksController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('payable', PayableController::class);
        Route::resource('receivable', ReceivableController::class);
        Route::resource('sales-targets', SalesTargetController::class);

        // Orders
        Route::get('orders/assign/worker/{order}', [OrderController::class, 'assignWorkerView'])->name('orders.assignWorkerView');
        Route::put('orders/assign/worker/{order}', [OrderController::class, 'assignWorker'])->name('orders.assignWorker');
        Route::get('orders/{order}/assign-delivery', [OrderController::class, 'assignDeliveryForm'])->name('orders.assign_delivery_form');
        Route::post('orders/{order}/assign-delivery', [OrderController::class, 'assignDelivery'])->name('orders.assign_delivery');
        Route::put('orders/{order}/complete', [OrderController::class, 'markAsCompleted'])->name('orders.complete');
        Route::get('/order-payments/{id}', [OrderPaymentController::class, 'index'])->name('order_payments.index');
        Route::get('/orders/{order}/pay', [OrderPaymentController::class, 'create'])->name('order_payments.create');
        Route::post('/order-payments', [OrderPaymentController::class, 'store'])->name('order_payments.store');
        Route::get('/order-payments/print_evidence/{id}', [OrderPaymentController::class, 'print_evidence'])->name('order_payments.evidence');

        Route::get('/tracking/truck', [TrucksController::class, 'tracking'])->name('tracking.truck');
    });

    // Akses role:admin atau owner
    Route::middleware('role:admin|owner')->group(function () {
        Route::prefix('laporan')->group(function () {
            Route::get('/finance', [Report::class, 'indexFinance'])->name('report_finance.index');
            Route::get('/finance/{source}', [Report::class, 'showFinance'])->name('report_finance.show');
            Route::get('/finance/{source}/print', [Report::class, 'printFinance'])->name('report_finance.print');

            Route::get('/finance/receivable/show', [Report::class, 'showReceivable'])->name('report_receivable.show');
            Route::get('/finance/receivable/printReceivable', [Report::class, 'printReceivable'])->name('report_receivable.print');

            Route::get('/finance/payable/show', [Report::class, 'showPayable'])->name('report_payable.show');
            Route::get('/finance/payable/printpayable', [Report::class, 'printPayable'])->name('report_payable.print');

            Route::get('/sales', [Report::class, 'indexSales'])->name('report_sales.index');
            Route::get('/sales/print', [Report::class, 'printSales'])->name('report_sales.print');

            Route::get('/business-growth', [Report::class, 'indexBusinessGrowth'])->name('report_business_growth.index');
            Route::get('/business-growth/print', [Report::class, 'printBusinessGrowth'])->name('report_business_growth.print');

            Route::get('/best-sellers', [Report::class, 'indexBestSellingProducts'])->name('report_best_sellers.index');
            Route::get('/best-sellers/print', [Report::class, 'printBestSellingProducts'])->name('report_best_sellers.print');

            Route::get('/low-stock', [Report::class, 'indexLowStock'])->name('report_low_stock.index');
            Route::get('/low-stock/print', [Report::class, 'printLowStock'])->name('report_low_stock.print');

            Route::get('/orders', [Report::class, 'indexOrders'])->name('report_orders.index');
            Route::get('/orders/print', [Report::class, 'printOrders'])->name('report_orders.print');

            Route::get('/employees', [Report::class, 'indexEmployees'])->name('report_employees.index');
            Route::get('/employees/print', [Report::class, 'printEmployees'])->name('report_employees.print');

            Route::get('/customers', [Report::class, 'indexCustomers'])->name('report_customers.index');
            Route::get('/customer/{id}', [Report::class, 'historyCustomer'])->name('report_customers.show');
            Route::get('/customers/print-customer', [Report::class, 'printCustomers'])->name('report_customers.print_customer');
            Route::get('/customer/{id}/print-history', [Report::class, 'printHistoryCustomer'])->name('report_customers.print_history');

            Route::get('/trucks', [Report::class, 'indexTrucks'])->name('report_trucks.index');
            Route::get('/trucks/print', [Report::class, 'printTrucks'])->name('report_trucks.print');
        });
    });

    Route::middleware('role:admin|employee')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    });
});

Route::prefix('customer')->name('customer.')->middleware(['auth', 'role:customer'])->group(
    function () {
        Route::get('/cart', [ECommerceController::class, 'cartIndex'])->name('cart.index');
        Route::post('/cart/add', [ECommerceController::class, 'add'])->name('cart.add');
        Route::put('/cart/update/{id}', [ECommerceController::class, 'update'])->name('cart.update');
        Route::delete('/cart/delete/{id}', [ECommerceController::class, 'destroy'])->name('cart.delete');
        Route::post('/cart/checkout', [ECommerceController::class, 'checkout'])->name('cart.checkout');

        Route::get('/orders', [ECommerceController::class, 'ordersIndex'])->name('orders.index');
        Route::get('/orders/{id}', [ECommerceController::class, 'showOrder'])
            ->name('orders.show');
        Route::patch('/customer/orders/{id}/complete', [ECommerceController::class, 'markAsCompleted'])->name('orders.complete');

        Route::get('/products/comment/{sales}/{product}', [ECommerceController::class, 'productComment'])->name('product.comments');
        Route::post('/create/product/comment/{sales}/{product}', [ECommerceController::class, 'createComment'])->name('create.product.comment');

        Route::get('/tracking/loc/{id}', [ECommerceController::class, 'truckTracking'])->name('track.location');
    }
);

require __DIR__ . '/auth.php';
