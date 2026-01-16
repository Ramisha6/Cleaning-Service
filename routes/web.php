<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CleanerController;
use App\Http\Controllers\CleaningServiceController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceBookingController;
use App\Http\Controllers\SliderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\ServiceBooking;
use App\Models\CleanerAssign;

// #################### Frontend Routes ####################
Route::middleware('web')->group(function () {
    // Home
    Route::get('/', [FrontendController::class, 'Index'])->name('index');

    // Services
    Route::get('/services', [FrontendController::class, 'Services'])->name('services');

    // Service Details
    Route::get('/service/{slug}', [FrontendController::class, 'ServiceDetails'])->name('service.details');

    // Booking Store (Guests + Auth users)
    Route::post('/service-booking/store', [FrontendController::class, 'ServiceBookingStore'])->name('service.booking.store');

    // About Us
    Route::get('/about-us', [FrontendController::class, 'AboutUs'])->name('about.us');

    // Contact Us
    Route::get('/contact-us', [FrontendController::class, 'ContactUs'])->name('contact.us');
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
        $total_bookings = ServiceBooking::count();
        $pending_bookings = ServiceBooking::where('status', 'pending')->count();
        $in_progress_bookings = ServiceBooking::where('status', 'in_progress')->count();
        $completed_bookings = ServiceBooking::where('status', 'completed')->count();
        return view('admin.index', compact('admin_data', 'total_bookings', 'pending_bookings', 'in_progress_bookings', 'completed_bookings'));
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

        // cleaner assign
        Route::post('/admin/booking/cleaner/assign', 'CleanerAssign')->name('admin.Booking.cleaner.assign');
    });

    Route::controller(CleanerController::class)->group(function () {
        Route::get('/admin/cleaner/list', 'index')->name('admin.cleaner.list');
        Route::get('/admin/cleaner/add', 'create')->name('admin.cleaner.add');
        Route::post('/admin/cleaner/store', 'store')->name('admin.cleaner.store');
        Route::get('/admin/cleaner/edit/{id}', 'edit')->name('admin.cleaner.edit');
        Route::post('/admin/cleaner/update/{id}', 'update')->name('admin.cleaner.update');
        Route::get('/admin/cleaner/delete/{id}', 'delete')->name('admin.cleaner.delete');
    });

    Route::controller(SliderController::class)->group(function () {
        Route::get('/admin/slider/list', 'list')->name('admin.slider.list');
        Route::get('/admin/slider/add', 'add')->name('admin.slider.add');
        Route::post('/admin/slider/store', 'store')->name('admin.slider.store');
        Route::get('/admin/slider/edit/{id}', 'edit')->name('admin.slider.edit');
        Route::post('/admin/slider/update/{id}', 'update')->name('admin.slider.update');
        Route::get('/admin/slider/delete/{id}', 'delete')->name('admin.slider.delete');
    });

    // ✅ Admin 404 fallback (must be LAST in this group)
    Route::fallback(function () {
        return response()->view('admin.errors.404', [], 404);
    });
});

// #################### Shared Routes (All authenticated users) ####################
Route::middleware('auth')->group(function () {
    // User profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// #################### Auth & Cleaner Login ####################
Route::get('/cleaner/login', function () {
    return view('cleaner.login');
});

Route::post('/cleaner-login-store', [CleanerController::class, 'CleanerLoginStore'])->name('cleaner.login.store');

// -------------------- Cleaner Area (example placeholder) --------------------
// Add cleaner routes here when you’re ready
Route::middleware(['auth', 'role:cleaner'])->group(function () {
    // Cleaner Dashboard
    Route::get('/cleaner/dashboard', function () {
        $admin_data = Auth::user();
        $total_bookings = CleanerAssign::where('cleaner_id', $admin_data->id)->with('booking')->count();
        $pending_bookings = CleanerAssign::where('cleaner_id', $admin_data->id)->where('status', 'pending')->with('booking')->count();
        $in_progress_bookings = CleanerAssign::where('cleaner_id', $admin_data->id)->where('status', 'in_progress')->with('booking')->count();
        $completed_bookings = CleanerAssign::where('cleaner_id', $admin_data->id)->where('status', 'completed')->with('booking')->count();

        return view('cleaner.index', compact('admin_data', 'total_bookings', 'pending_bookings', 'in_progress_bookings', 'completed_bookings'));
    })->name('cleaner.dashboard');

    // cleaner booking list
    Route::get('/cleaner/booking/list', [CleanerController::class, 'CleanerBookingList'])->name('cleaner.Booking.list');

    Route::post('/booking/update-status', [CleanerController::class, 'updateStatus'])->name('cleaner.booking.update.status');
    Route::get('/clear/show-booking/{id}', [CleanerController::class, 'showBooking'])->name('cleaner.booking.show');
});
