<?php

use Illuminate\Support\Facades\Route;
use App\Models\Court;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BuyerAuthController;
use App\Http\Controllers\SellerAuthController;
use App\Http\Controllers\SellerCourtController;
use App\Http\Controllers\SellerBookingController;
use App\Http\Controllers\PaymentController;

// ===============================
// HALAMAN UTAMA
// ===============================

Route::get('/', function () {
    $courts = Court::where('status', 'active')->latest()->get();

    return view('booking', compact('courts'));
});

Route::get('/profile', function () {
    return view('profile');
});

// ===============================
// BUYER REGISTER & LOGIN
// ===============================

Route::get('/buyer/register', [BuyerAuthController::class, 'showRegister'])
    ->name('buyer.register');

Route::post('/buyer/register', [BuyerAuthController::class, 'register'])
    ->name('buyer.register.store');

Route::get('/buyer/login', [BuyerAuthController::class, 'showLogin'])
    ->name('buyer.login');

Route::post('/buyer/login', [BuyerAuthController::class, 'login'])
    ->name('buyer.login.store');

// ===============================
// SELLER REGISTER & LOGIN
// ===============================

Route::get('/seller/register', [SellerAuthController::class, 'showRegister'])
    ->name('seller.register');

Route::post('/seller/register', [SellerAuthController::class, 'register'])
    ->name('seller.register.store');

Route::get('/seller/login', [SellerAuthController::class, 'showLogin'])
    ->name('seller.login');

Route::post('/seller/login', [SellerAuthController::class, 'login'])
    ->name('seller.login.store');

// ===============================
// FITUR KHUSUS BUYER
// ===============================

Route::middleware('role:buyer')->group(function () {

    Route::post('/buyer/logout', [BuyerAuthController::class, 'logout'])
        ->name('buyer.logout');

    Route::post('/booking/{id}', [BookingController::class, 'store'])
        ->name('booking.store');

    Route::get('/booking-success/{id}', [BookingController::class, 'success'])
        ->name('booking.success');

    Route::get('/my-bookings', [BookingController::class, 'index'])
        ->name('booking.index');

    // PEMBAYARAN BUYER
    Route::get('/payment/{id}', [PaymentController::class, 'show'])
        ->name('payment.show');

    Route::post('/payment/{id}', [PaymentController::class, 'store'])
        ->name('payment.store');

});

// ===============================
// FITUR KHUSUS SELLER
// ===============================

Route::middleware('role:seller')->group(function () {

    Route::post('/seller/logout', [SellerAuthController::class, 'logout'])
        ->name('seller.logout');

    // ===============================
    // KELOLA LAPANGAN
    // ===============================

    Route::get('/seller/courts', [SellerCourtController::class, 'index'])
        ->name('seller.courts.index');

    Route::get('/seller/courts/create', [SellerCourtController::class, 'create'])
        ->name('seller.courts.create');

    Route::post('/seller/courts', [SellerCourtController::class, 'store'])
        ->name('seller.courts.store');

    Route::get('/seller/courts/{id}/edit', [SellerCourtController::class, 'edit'])
        ->name('seller.courts.edit');

    Route::put('/seller/courts/{id}', [SellerCourtController::class, 'update'])
        ->name('seller.courts.update');

    // SOFT DELETE
    Route::delete('/seller/courts/{id}', [SellerCourtController::class, 'destroy'])
        ->name('seller.courts.destroy');

    // RESTORE COURT
    Route::patch('/seller/courts/{id}/restore', [SellerCourtController::class, 'restore'])
        ->name('seller.courts.restore');

    // PERMANENT DELETE
    Route::delete('/seller/courts/{id}/force-delete', [SellerCourtController::class, 'forceDelete'])
        ->name('seller.courts.force-delete');

    // ===============================
    // KELOLA BOOKING
    // ===============================

    Route::get('/seller/bookings', [SellerBookingController::class, 'index'])
        ->name('seller.bookings.index');

    Route::patch('/seller/bookings/{id}/confirm', [SellerBookingController::class, 'confirm'])
        ->name('seller.bookings.confirm');

    Route::patch('/seller/bookings/{id}/reject', [SellerBookingController::class, 'reject'])
        ->name('seller.bookings.reject');

    // ===============================
    // KELOLA PEMBAYARAN
    // ===============================

    Route::get('/seller/bookings/{id}/payment-proof', [SellerBookingController::class, 'paymentProof'])
        ->name('seller.bookings.payment-proof');

    Route::patch('/seller/bookings/{id}/verify-payment', [SellerBookingController::class, 'verifyPayment'])
        ->name('seller.bookings.verify-payment');

    Route::patch('/seller/bookings/{id}/reject-payment', [SellerBookingController::class, 'rejectPayment'])
        ->name('seller.bookings.reject-payment');

});

// ===============================
// DETAIL LAPANGAN
// ===============================

Route::get('/booking/{id}', [BookingController::class, 'show'])
    ->name('booking.show');
