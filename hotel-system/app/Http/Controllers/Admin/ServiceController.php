<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // 2MB Max
            'is_active' => 'boolean',
        ]);

        // Save the image to 'storage/app/public/services'
        $path = $request->file('image')->store('services', 'public');

        Service::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'image_path' => $path,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return back()->with('message', 'Service added successfully!');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        // If a new image was uploaded, delete the old one and save the new one
        if ($request->hasFile('image')) {
            if ($service->image_path) {
                Storage::disk('public')->delete($service->image_path);
            }
            $service->image_path = $request->file('image')->store('services', 'public');
        }

        $service->title = $validated['title'];
        $service->subtitle = $validated['subtitle'];
        $service->is_active = $validated['is_active'] ?? true;
        $service->save();

        return back()->with('message', 'Service updated successfully!');
    }

    public function destroy(Service $service)
    {
        // Delete the physical image file first!
        if ($service->image_path) {
            Storage::disk('public')->delete($service->image_path);
        }
        $service->delete();

        return back()->with('message', 'Service deleted.');
    }
}