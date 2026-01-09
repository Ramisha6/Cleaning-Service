<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CleaningServiceController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceBookingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// #################### Frontend Routes ####################
Route::middleware('web')->group(function () {
    // Home
    Route::get('/', [FrontendController::class, 'Index'])->name('index');

    // Services
    Route::get('/service', [FrontendController::class, 'Service'])->name('service');

    // Service Details
    Route::get('/service/{slug}', [FrontendController::class, 'ServiceDetails'])->name('service.details');

    // Booking Store (Guests + Auth users)
    Route::post('/service-booking/store', [FrontendController::class, 'ServiceBookingStore'])->name('service.booking.store');
});

// #################### Auth & Admin Login ####################
Route::get('/admin/login', function () {
    return view('admin.login');
});

Route::post('/login-store', [AdminController::class, 'store'])->name('admin.login.store');

require __DIR__ . '/auth.php';

// #################### User Dashboard Routes (Only users) ####################
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [FrontendController::class, 'UserDashboard'])->name('dashboard');

    Route::get('/dashboard/service-purchases/{booking}', [FrontendController::class, 'ServicePurchaseShow'])->name('user.service.purchase.show');
    Route::get('/dashboard/service-purchases/{booking}/invoice', [FrontendController::class, 'ServicePurchaseInvoice'])->name('user.service.purchase.invoice');
    Route::get('/dashboard/service-purchases/{booking}/invoice/print', [FrontendController::class, 'ServicePurchaseInvoicePrint'])->name('user.service.purchase.invoice.print');
});

// #################### Admin Panel Routes (Only admins) ####################
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        $admin_data = Auth::user();
        return view('admin.index', compact('admin_data'));
    })->name('admin.dashboard');

    // Service Management
    Route::controller(CleaningServiceController::class)->group(function () {
        Route::get('/admin/service/list', 'index')->name('admin.Service.list');
        Route::get('/admin/service/add', 'create')->name('admin.Service.add');
        Route::post('/admin/service/store', 'store')->name('admin.Service.store');
        Route::get('/admin/service/edit/{id}', 'edit')->name('admin.Service.edit');
        Route::post('/admin/service/update/{id}', 'update')->name('admin.Service.update');
        Route::get('/admin/service/delete/{id}', 'delete')->name('admin.Service.delete');
    });

    Route::controller(ServiceBookingController::class)->group(function () {
        Route::get('/admin/booking/list', 'index')->name('admin.Booking.list');
        Route::get('/admin/booking/show/{id}', 'show')->name('admin.Booking.show');

        Route::post('/admin/booking/confirm/{id}', 'confirm')->name('admin.booking.confirm');
        Route::post('/admin/booking/cancel/{id}', 'cancel')->name('admin.booking.cancel');
        Route::post('/admin/booking/payment/verify/{id}', 'verifyPayment')->name('admin.booking.payment.verify');
        Route::post('/admin/booking/payment/reject/{id}', 'rejectPayment')->name('admin.booking.payment.reject');

        Route::get('/admin/booking/invoice/{id}', 'invoice')->name('admin.Booking.invoice');
        Route::get('/admin/booking/invoice/{id}/download', 'invoiceDownload')->name('admin.Booking.invoice.download');
    });
});

// #################### Shared Routes (All authenticated users) ####################
Route::middleware('auth')->group(function () {
    // User profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -------------------- Cleaner Area (example placeholder) --------------------
// Add cleaner routes here when you’re ready
Route::middleware(['auth', 'role:cleaner'])->group(function () {
    // Route::get('/cleaner/dashboard', ...)->name('cleaner.dashboard');
});
