<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;

// Public Routes
Route::get('/', function () {
    return view('customer.dashboard');
});

// Authentication Routes
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Customer Routes
Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('/products', [ProductController::class, 'showToCustomer'])->name('products.customer');
Route::get('/products/{product}', [ProductController::class, 'showProductDetails'])->name('products.view');
Route::get('/payment', function () { return view('customer.payment'); })->name('payment');
Route::get('/about', function () { return view('customer.about'); })->name('about');
Route::get('/contact', function () { return view('customer.contact'); })->name('contact');

// Password Management Routes
Route::get('password/forgot', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('password/email', [AuthController::class, 'handleForgotPassword'])->name('password.email');
Route::get('password/reset/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'resetPassword'])->name('password.update');
Route::get('password/change', [AuthController::class, 'showChangePasswordForm'])->name('auth.change-password-form');
Route::post('password/change', [AuthController::class, 'changePassword'])->name('auth.change-password');

// Admin Authentication Routes (Unprotected)
Route::get('admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminController::class, 'login'])->name('admin.login.post');

// Admin Routes (Protected by AdminMiddleware)
// Inside the admin middleware group
Route::middleware([AdminMiddleware::class])->group(function () {
    // Admin Dashboard & Authentication
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('admin/register', [AdminController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('admin/register', [AuthController::class, 'registerAdmin'])->name('admin.register.post');
    
    // Order Management
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('/admin/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::patch('/admin/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.updateStatus');
    
    // Product Management Routes
    Route::resource('products', ProductController::class);
    Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::patch('/products/{id}/status', [ProductController::class, 'updateProductStatus'])->name('products.updateStatus');
    Route::get('/products/{product}/variants', [ProductController::class, 'getVariants'])
        ->name('products.variants');
    Route::get('/products/{product}/variants', [ProductController::class, 'getVariants'])
    ->name('products.variants');
});

