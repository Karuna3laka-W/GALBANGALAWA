<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PackageController;
use App\Models\Package;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;

// 1. Combined Home Route: Sends auth status AND packages
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        // 'packages' => Package::all(), 
        'packages' => Package::where('is_active', true)->latest()->get(),
    ]);
});

// 2. Wedding Inquiry Details Page
Route::get('/inquiry-details', function (Request $request) {
    return Inertia::render('InquiryDetails', [
        'selectedDate' => $request->query('date'),
        'selectedGuests' => $request->query('guests'),
    ]);
});

// 3. Admin & Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // This points to your PackageController so the Admin Dashboard works
    Route::get('/dashboard', [PackageController::class, 'index'])->name('dashboard');
    Route::patch('/admin/packages/{package}', [PackageController::class, 'updatePrice'])->name('admin.packages.update');
});

// 4. User Profile Routes (Breeze defaults)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';