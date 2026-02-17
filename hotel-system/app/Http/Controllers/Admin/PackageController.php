<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PackageController extends Controller
{
   

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

public function index()
    {
        // This fetches EVERYTHING. If it returns 0, your DB is empty.
        return Inertia::render('Admin/Dashboard', [
            'packages' => Package::latest()->get(),
        ]);
    }

   public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'has_offer' => 'boolean',
            'offer_percent' => 'nullable|integer|min:1|max:100',
        ]);

        Package::create($validated);

        return back()->with('message', 'Package created successfully!');
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'has_offer' => 'boolean',
            'offer_percent' => 'nullable|integer|min:1|max:100',
        ]);

        $package->update($validated);

        return back()->with('message', 'Package updated successfully!');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return back()->with('message', 'Package deleted permanently.');
    }
}