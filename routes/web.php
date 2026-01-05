<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CleaningServiceController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Models\CleaningServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// #################### Frontend Controller ####################
Route::middleware('web')->group(function () {
    // Home
    Route::get('/', [FrontendController::class, 'Index'])->name('index');

    // Service Page
    Route::get('/service', [FrontendController::class, 'Service'])->name('service');

    // Service Details
    Route::get('/service/{slug}', [FrontendController::class, 'ServiceDetails'])->name('service.details');

});

Route::get('/admin/login', function () {
    return view('admin.login');
});

Route::post('/login-store', [AdminController::class, 'store'])->name('admin.login.store');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard', function () {
        $admin_data = Auth::user();
        return view('admin.index', compact('admin_data'));
    })->name('admin.dashboard');

    Route::get('/admin/service/list', [CleaningServiceController::class, 'index'])->name('admin.Service.list');
    Route::get('/admin/service/add', [CleaningServiceController::class, 'create'])->name('admin.Service.add');
    Route::post('/admin/service/store', [CleaningServiceController::class, 'store'])->name('admin.Service.store');
    Route::get('/admin/service/edit/{id}', [CleaningServiceController::class, 'edit'])->name('admin.Service.edit');
    Route::post('/admin/service/update/{id}', [CleaningServiceController::class, 'update'])->name('admin.Service.update');
    Route::get('/admin/service/delete/{id}', [CleaningServiceController::class, 'delete'])->name('admin.Service.delete');
});
