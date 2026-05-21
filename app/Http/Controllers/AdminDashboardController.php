<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('status', 'confirmed')
            ->where('date', '>=', Carbon::today()->toDateString())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        $availabilities = Availability::where('date', '>=', Carbon::today()->toDateString())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('admin.dashboard', compact('appointments', 'availabilities'));
    }

    public function storeAvailability(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        Availability::create([
            'date' => $request->date,
            'start_time' => $request->start_time . ':00',
            'end_time' => $request->end_time . ':00',
        ]);

        return back()->with('success', 'Plage de disponibilité ajoutée avec succès.');
    }

    public function destroyAvailability($id)
    {
        $availability = Availability::findOrFail($id);
        $availability->delete();

        return back()->with('success', 'Plage de disponibilité supprimée.');
    }

    public function cancelAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'cancelled']);


        return back()->with('success', 'Rendez-vous annulé et client notifié.');
    }
}