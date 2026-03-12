<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'check_in'         => 'required|date|after_or_equal:today',
            'check_out'        => 'required|date|after:check_in',
            'adults'           => 'required|integer|min:1|max:10',
            'children'         => 'required|integer|min:0|max:6',
            'room_type'        => 'required|string|in:standard,deluxe,suite,villa',
            'package_id'       => 'nullable|integer|exists:packages,id',
            'service_ids'      => 'nullable|array',
            'service_ids.*'    => 'integer|exists:services,id',
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'phone'            => 'required|string|max:50',
            'country'          => 'required|string|max:100',
            'special_requests' => 'nullable|string|max:2000',
        ]);

        Reservation::create($validated);

        return back()->with('message', 'Reservation submitted successfully!');
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,confirmed,cancelled',
        ]);

        $reservation->update($validated);

        return back()->with('message', 'Reservation status updated.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return back()->with('message', 'Reservation deleted.');
    }
}
