<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SeasonalOfferController;
use App\Http\Controllers\Admin\ServiceController;
use App\Models\Package;
use App\Models\Reservation;
use App\Models\SeasonalOffer;
use App\Models\Service;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Artisan;



Route::get('/fix-storage', function () {
    Artisan::call('storage:link');
    return "Storage link created successfully!";
});

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

// 2. Booking Page
Route::get('/booking', function () {
    return Inertia::render('Booking', [
        'packages' => Package::where('is_active', true)->latest()->get(),
        'services' => Service::where('is_active', true)->latest()->get(),
    ]);
})->name('booking');

// Store reservation (public route — no auth required)
Route::post('/booking', [ReservationController::class, 'store'])->name('reservation.store');

// 3. Wedding Inquiry Details Page
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
            'services' => Service::latest()->get(),
            'reservations' => Reservation::with('package')->latest()->get(),
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

    // Reservation Management
    Route::put('/admin/reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('admin.reservations.status');
    Route::delete('/admin/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('admin.reservations.destroy');
});

// 4. User Profile Routes (Breeze defaults)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';