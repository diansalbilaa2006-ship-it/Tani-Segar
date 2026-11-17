
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\FarmerVerificationController;
use App\Http\Controllers\Petani\ProductController;
use App\Http\Controllers\Petani\OrderController as PetaniOrderController;
use App\Http\Controllers\Pembeli\ProductCatalogController;
use App\Http\Controllers\Pembeli\CartController;
use App\Http\Controllers\Pembeli\CheckoutController;
use App\Http\Controllers\Pembeli\OrderController;
use App\Http\Controllers\Admin\PaymentVerificationController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController;


// Halaman utama sementara
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Registrasi
Route::get('/register', [AuthController::class, 'showRegister'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest')
    ->name('register.store');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login.process');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

    // Fitur khusus admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/calon-petani', [FarmerVerificationController::class, 'index'])
            ->name('farmers.index');

        Route::patch('/calon-petani/{id}/setujui', [FarmerVerificationController::class, 'approve'])
            ->name('farmers.approve');

        Route::patch('/calon-petani/{id}/tolak', [FarmerVerificationController::class, 'reject'])
            ->name('farmers.reject');
            // Verifikasi pembayaran
        Route::get('/pembayaran', [PaymentVerificationController::class, 'index'])
          ->name('payments.index');

          // Menyetujui pembayaran
        Route::patch('/pembayaran/{id}/setujui', [PaymentVerificationController::class, 'approve'])
         ->name('payments.approve');

            // Menolak pembayaran
        Route::patch('/pembayaran/{id}/tolak', [PaymentVerificationController::class, 'reject'])
         ->name('payments.reject');
         // Kelola pesanan
        Route::get('/pesanan', [AdminOrderController::class, 'index'])
         ->name('orders.index');

        Route::get('/pesanan/{id}', [AdminOrderController::class, 'show'])
         ->name('orders.show');
         // Kelola kategori
          Route::resource('/kategori', CategoryController::class)
         ->except(['show'])
          ->parameters(['kategori' => 'category'])
          ->names('categories');
    });

    // Fitur khusus petani
Route::middleware(['auth', 'role:petani'])
    ->prefix('petani')
    ->name('petani.')
    ->group(function () {

       Route::resource('produk', ProductController::class)
    ->except(['show'])
    ->names('products');

    Route::get('/pesanan', [PetaniOrderController::class, 'index'])
    ->name('orders.index');

Route::get('/pesanan/{id}', [PetaniOrderController::class, 'show'])
    ->name('orders.show');
    Route::patch('/pesanan/{id}/kirim', [PetaniOrderController::class, 'ship'])
    ->name('orders.ship');
    });

    // Fitur khusus pembeli
Route::middleware(['auth', 'role:pembeli'])
    ->prefix('pembeli')
    ->name('pembeli.')
    ->group(function () {

        // Katalog produk
        Route::get('/produk', [
            \App\Http\Controllers\Pembeli\ProductCatalogController::class,
            'index'
        ])->name('products.index');

        // Tambah produk ke keranjang
        Route::post('/keranjang/{productId}', [
            CartController::class,
            'store'
        ])->name('cart.store');

        // Menampilkan keranjang
        Route::get('/keranjang', [CartController::class, 'index'])
        ->name('cart.index');

        // Mengubah jumlah produk
        Route::put('/keranjang/{itemId}', [CartController::class, 'update'])
      ->name('cart.update');

        // Menghapus produk
        Route::delete('/keranjang/{itemId}', [CartController::class, 'destroy'])
      ->name('cart.destroy');

        // Checkout
        Route::get('/checkout', [
            \App\Http\Controllers\Pembeli\CheckoutController::class,
            'index'
        ])->name('checkout.index');

        Route::post('/checkout', [
            \App\Http\Controllers\Pembeli\CheckoutController::class,
            'store'
        ])->name('checkout.store');
        // Riwayat pesanan
        Route::get('/pesanan', [OrderController::class, 'index'])
         ->name('orders.index');

        // Detail pesanan
        Route::get('/pesanan/{id}', [OrderController::class, 'show'])
         ->name('orders.show');

         // Upload bukti pembayaran
        Route::post('/pesanan/{id}/bukti-pembayaran', [OrderController::class, 'uploadPaymentProof'])
         ->name('orders.payment-proof');
         Route::patch('/pesanan/{id}/diterima', [OrderController::class, 'confirmReceived'])
        ->name('orders.confirm-received');
        // Detail produk
        Route::get('/produk/{id}', [
        \App\Http\Controllers\Pembeli\ProductDetailController::class,
        'show'
        ])->name('products.show');
        // Menyimpan ulasan produk
        Route::post('/produk/{id}/ulasan', [
        \App\Http\Controllers\Pembeli\ReviewController::class,
        'store'
        ])->name('products.reviews.store');
        
    });

        