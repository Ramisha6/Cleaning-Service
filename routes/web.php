<?php

use App\Http\Controllers\CleaningServiceController;
use App\Http\Controllers\ProfileController;
use App\Models\CleaningService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.index');
});

Route::get('/admin/dashboard', function () {
    return view('admin.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

 Route::get('/admin/service/list', [CleaningServiceController::class, 'index'])->name('admin.Service.list');
 Route::get('/admin/service/add', [CleaningServiceController::class, 'create'])->name('admin.Service.add');
 Route::post('/admin/service/store', [CleaningServiceController::class, 'store'])->name('admin.Service.store');
 Route::get('/admin/service/edit/{id}', [CleaningServiceController::class, 'edit'])->name('admin.Service.edit');
 Route::post('/admin/service/update', [CleaningServiceController::class, 'update'])->name('admin.Service.update');
 Route::get('/admin/service/delete/{id}', [CleaningServiceController::class, 'delete'])->name('admin.Service.delete');
