<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PackageController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'packages' => Package::all(),
        ]);
    }

    public function updatePrice(Request $request, Package $package)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $package->update([
            'price' => $request->price
        ]);

        return back()->with('message', 'Price updated successfully!');
    }

    // Add this method inside your PackageController class
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
    ]);

    Package::create($validated);

    return back()->with('message', 'Package created successfully!');
}
}