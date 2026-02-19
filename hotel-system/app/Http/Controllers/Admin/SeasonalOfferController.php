<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeasonalOffer;
use Illuminate\Http\Request;

class SeasonalOfferController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'badge_text' => 'required|string|max:50',
            'description' => 'required|string',
            'is_active' => 'boolean',
        ]);

        // Pro-tip: If you only want ONE active offer at a time, 
        // you can deactivate all others before creating this one!
        if ($validated['is_active'] ?? false) {
            SeasonalOffer::where('is_active', true)->update(['is_active' => false]);
        }

        SeasonalOffer::create($validated);

        return back()->with('message', 'Seasonal offer published!');
    }

   public function update(Request $request, SeasonalOffer $offer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'badge_text' => 'required|string|max:50',
            'description' => 'required|string',
            'is_active' => 'boolean',
            'theme_color' => 'required|string|size:7',
        ]);


        // dd($validated); 

        if ($validated['is_active'] ?? false) {
            SeasonalOffer::where('id', '!=', $offer->id)->update(['is_active' => false]);
        }

        $offer->update($validated);

        return back()->with('message', 'Seasonal offer updated!');
    }

    public function destroy(SeasonalOffer $offer)
    {
        $offer->delete();
        return back()->with('message', 'Seasonal offer removed.');
    }
}