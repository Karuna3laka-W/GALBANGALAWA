<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SeasonalOfferController;
use App\Http\Controllers\Admin\ServiceController; // <-- Added Service Controller
use App\Models\Package;
use App\Models\SeasonalOffer;
use App\Models\Service; // <-- Added Service Model
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;

// 1. Combined Home Route: Sends auth status, packages, Seasonal Offers, AND Services
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        
        // Fetch active packages
        'packages' => Package::where('is_active', true)->latest()->get(),
        
        // Fetch the ONE active seasonal offer
        'specialOffer' => SeasonalOffer::where('is_active', true)->latest()->first(),

        // NEW: Fetch all active services for the 3D rotating slider
        'services' => Service::where('is_active', true)->latest()->get(),
    ]);
});

// 2. Wedding Inquiry Details Page
Route::get('/inquiry-details', function (Request $request) {
    return Inertia::render('InquiryDetails', [
        'selectedDate' => $request->query('date'),
        'selectedGuests' => $request->query('guests'),
    ]);
});

// 3. Admin & Protected Routes (Consolidated)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard: Using a closure to load all three database tables into your Admin Panel
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard', [
            'packages' => Package::latest()->get(),
            'seasonalOffers' => SeasonalOffer::latest()->get(),
            'services' => Service::latest()->get(), // <-- Added Services to Dashboard
        ]);
    })->name('dashboard');

    // Package Management
    Route::post('/admin/packages', [PackageController::class, 'store'])->name('admin.packages.store');
    Route::put('/admin/packages/{package}', [PackageController::class, 'update'])->name('admin.packages.update');
    Route::delete('/admin/packages/{package}', [PackageController::class, 'destroy'])->name('admin.packages.destroy');

    // Seasonal Offer Management
    Route::post('/admin/seasonal-offers', [SeasonalOfferController::class, 'store'])->name('admin.offers.store');
    Route::put('/admin/seasonal-offers/{offer}', [SeasonalOfferController::class, 'update'])->name('admin.offers.update');
    Route::delete('/admin/seasonal-offers/{offer}', [SeasonalOfferController::class, 'destroy'])->name('admin.offers.destroy');

    // NEW: Service Management (File Uploads)
    Route::post('/admin/services', [ServiceController::class, 'store'])->name('admin.services.store');
    // NOTE: Inertia file uploads require a POST route even for updating, we use _method=PUT on the frontend
    Route::post('/admin/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update'); 
    Route::delete('/admin/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');
});

// 4. User Profile Routes (Breeze defaults)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';