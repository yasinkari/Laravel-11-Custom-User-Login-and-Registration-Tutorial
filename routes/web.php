<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ToyyibpayController; // Ensure ToyyibpayController is imported
use App\Http\Controllers\OrderController; // Add this import
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\ReviewController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Public Routes
Route::get('/', function () {
    return view('customer.dashboard');
});

// Authentication Routes
Route::get('login', [AuthController::class, 'index'])->name(name: 'login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::post('register', [AuthController::class, 'registerAdmin'])->name('admin.register.post'); // Changed name
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Password Management Routes
Route::get('password/forgot', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('password/email', [AuthController::class, 'handleForgotPassword'])->name('password.email');
Route::get('password/reset/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'resetPassword'])->name('password.update');
Route::get('password/change', [AuthController::class, 'showChangePasswordForm'])->name('auth.change-password-form');
Route::post('password/change', [AuthController::class, 'changePassword'])->name('auth.change-password');

// Public Customer Product Routes (no auth required)
Route::get('/products', [ProductController::class, 'showToCustomer'])->name('products.customer');
Route::get('/products/{product}', [ProductController::class, 'showProductDetails'])->name('products.view');
Route::get('/about', function () { return view('customer.about'); })->name('about');
Route::get('/contact', function () { return view('customer.contact'); })->name('contact');

// Admin Authentication Routes (Unprotected)
// Route::get('admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
// Route::post('admin/login', action: [AdminController::class, 'login'])->name('admin.login.post');

// Admin Routes (Protected by AdminMiddleware)
Route::middleware([AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard & Authentication
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('register', [AdminController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'registerAdmin'])->name('register.post');
    
    // Order Management
    Route::get('orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.updateStatus');

    // Product Management
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::patch('products/{id}/status', [ProductController::class, 'updateProductStatus'])->name('products.updateStatus');
    Route::patch('products/{id}/visibility', [ProductController::class, 'updateVisibility'])->name('products.updateVisibility');
    Route::get('products/{product}/variants', [ProductController::class, 'getVariants'])->name('products.variants');
    
    // Product Variants
    Route::get('products/variants/{variant}/edit', [ProductController::class, 'editVariant'])->name('products.variants.edit');
    Route::get('products/{product}/variants/create', function($product) {
        return redirect()->route('admin.products.edit', $product)->with('openVariantForm', true);
    })->name('products.variants.create');
    Route::put('products/variants/{variant}', [ProductController::class, 'updateVariant'])->name('products.variants.update');
    Route::post('products/{productID}/variants', [ProductController::class, 'storeVariant'])->name('products.variants.store');
    Route::delete('products/variants/{variant}', [ProductController::class, 'destroyVariant'])->name('products.variants.destroy');
    
    // Promotions
    Route::get('promotions', [PromotionController::class, 'index'])->name('promotions.index');
    Route::get('promotions/create', [PromotionController::class, 'create'])->name('promotions.create');
    Route::post('promotions', [PromotionController::class, 'store'])->name('promotions.store');
    Route::get('promotions/{promotion}', [PromotionController::class, 'show'])->name('promotions.show');
    Route::get('promotions/{promotion}/edit', [PromotionController::class, 'edit'])->name('promotions.edit');
    Route::put('promotions/{promotion}', [PromotionController::class, 'update'])->name('promotions.update');
    Route::delete('promotions/{promotion}', [PromotionController::class, 'destroy'])->name('promotions.destroy');
    Route::patch('promotions/{promotion}/toggle-status', [PromotionController::class, 'toggleStatus'])->name('promotions.toggle-status');
});

// Cart routes
Route::middleware(['auth'])->group(function () {
    // Example of a protected route that requires email verification
    Route::get('/dashboard', [AuthController::class, 'dashboard'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{record}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/cart/count', [CartController::class, 'countCart'])->name('cart.count');

    // ToyyibPay routes
    Route::get('/payment/status', [ToyyibpayController::class, 'paymentStatus'])->name('payment.status');
    Route::post('/payment/callback', [ToyyibpayController::class, 'paymentCallback'])->name('payment.callback');
    Route::post('/payment/notification', [ToyyibpayController::class, 'paymentCallback'])->name('payment.notification');

    // Order status pages (after payment attempt)
    Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/order/failed', [OrderController::class, 'failed'])->name('order.failed');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/receive', [OrderController::class, 'receive'])->name('orders.receive');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.password.form');
    Route::put('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Review routes for authenticated users
Route::middleware(['auth'])->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/cart-record/{cartRecordID}', [ReviewController::class, 'showByCartRecordID'])->name('reviews.byCartRecord');
});

// Admin review routes
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Review management routes
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    // Display reviews by cartID
    Route::get('reviews/cart/{cartID}', [ReviewController::class, 'showByCartID'])->name('reviews.byCart');
});

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard')->withSuccess('Email verified successfully!');
})->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->withSuccess('Verification link sent!');
})->name('verification.send');



