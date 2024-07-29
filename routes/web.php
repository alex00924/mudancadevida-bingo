<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrdersExportController;
use App\Livewire\Admin\CardImages;
use App\Livewire\Admin\SiteSettings;
use App\Livewire\Admin\UserList;
use App\Livewire\Admin\OrderList as AdminOrderList;
use App\Livewire\Admin\SellerList;
use App\Livewire\CardList as CustomerCardList;
use App\Livewire\NewOrder;
use App\Livewire\OrderDetail;
use App\Livewire\OrderList;
use App\Livewire\Seller\SellerOrderList;
use App\Livewire\Seller\SellerUserList;
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

Route::get('/migrate', function () {
    Artisan::call('migrate');
});
Route::get('/storage_link', function () {
    Artisan::call('storage:link');
});
Route::get('/seed', function () {
    Artisan::call('db:seed');
});
Route::get('/seed/{class_name}', function ($class_name) {
    Artisan::call('db:seed ' . $class_name);
});

Route::get('/artisan/{cmd}', function ($cmd) {
    Artisan::call($cmd);
});


Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/check-payment-status', [DashboardController::class, 'checkPaymentStatus']);

Route::get('order/new', NewOrder::class)->name('order.new');//->middleware(['card-selling']);

Route::middleware([
    'auth',
])->group(function () {
    Route::view('profile', 'profile')->name('profile');
    Route::get('order/list', OrderList::class)->name('order.list');
    Route::get('card/list', CustomerCardList::class)->name('customer.cards');
    Route::get('order/details/{id}', OrderDetail::class)->name('order.detail');
});

Route::middleware([
    'auth',
    'role:admin',
])->prefix("admin")->group(function () {
    Route::get('user/list', UserList::class)->name('admin.user.list');
    Route::get('order/list', AdminOrderList::class)->name('admin.order.list');
    Route::get('card-imgs', CardImages::class)->name('admin.card.imgs');
    Route::get('setting', SiteSettings::class)->name('admin.setting');
    Route::get('seller/list', SellerList::class)->name('admin.seller.list');
    Route::get('order/export', [OrdersExportController::class, 'export'])->name('admin.order.export');
});

Route::middleware([
    'auth',
    'role:seller',
])->prefix("vendedor")->group(function () {
    Route::get('user/list', SellerUserList::class)->name('seller.user.list');
    Route::get('order/list', SellerOrderList::class)->name('seller.order.list');
    Route::get('order/export', [OrdersExportController::class, 'export'])->name('seller.order.export');
});

require __DIR__.'/auth.php';

Route::get('not-selling-now', function() {
    if (\App\Models\SiteSetting::isEnabledSelling()) {
        return redirect("/");
    }
    return view('not-selling');
});

Route::get('not-enough-stock', function() {
    return view('not-selling');
});
