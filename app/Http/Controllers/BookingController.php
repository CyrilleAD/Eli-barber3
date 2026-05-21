<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function showBookingForm(Request $request)
    {
        $selectedDate = $request->query('date', Carbon::today()->toDateString());
        
        $availableSlots = $this->getAvailableSlotsForDate($selectedDate);

        return view('client.book', compact('selectedDate', 'availableSlots'));
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
        ]);

        $date = $request->date;
        $startTimeStr = $request->start_time;
        
        $startTime = Carbon::createFromFormat('Y-m-d H:i', "$date $startTimeStr");
        $endTime = (clone $startTime)->addMinutes(45);
        
        $endTimeStr = $endTime->format('H:i');

        $freeSlots = $this->getAvailableSlotsForDate($date);
        
        if (!in_array($startTimeStr, $freeSlots)) {
            return back()->withInput()->withErrors(['start_time' => 'Ce créneau de 45 minutes n\'est plus disponible. Veuillez en choisir un autre.']);
        }

        $appointment = Appointment::create([
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'date' => $date,
            'start_time' => $startTimeStr . ':00',
            'end_time' => $endTimeStr . ':00',
            'status' => 'confirmed'
        ]);

    
        session(['last_appointment' => $appointment]);

        return redirect()->route('client.success');
    }

    public function showSuccess()
    {
        $appointment = session('last_appointment');

        if (!$appointment) {
            return redirect()->route('client.landing');
        }

        return view('client.success', compact('appointment'));
    }

    private function getAvailableSlotsForDate($dateString)
    {
        $slots = [];
        $carbonDate = Carbon::parse($dateString);

        $availabilities = Availability::where('date', $dateString)
            ->orderBy('start_time')
            ->get();

        $appointments = Appointment::where('date', $dateString)
            ->where('status', 'confirmed')
            ->get();

        foreach ($availabilities as $availability) {
            $start = Carbon::createFromFormat('Y-m-d H:i:s', "$dateString $availability->start_time");
            $end = Carbon::createFromFormat('Y-m-d H:i:s', "$dateString $availability->end_time");

            // Découper la plage horaire en blocs de 45 minutes
            while ($start->copy()->addMinutes(45)->lte($end)) {
                $slotStart = $start->copy();
                $slotEnd = $start->copy()->addMinutes(45);

                $slotStartStr = $slotStart->format('H:i');
                $slotEndStr = $slotEnd->format('H:i');

                $isPast = false;
                if ($carbonDate->isToday()) {
                    if ($slotStart->lt(Carbon::now())) {
                        $isPast = true;
                    }
                }

                $isOverlapping = false;
                foreach ($appointments as $appointment) {
                    $appStart = Carbon::createFromFormat('Y-m-d H:i:s', "$dateString $appointment->start_time");
                    $appEnd = Carbon::createFromFormat('Y-m-d H:i:s', "$dateString $appointment->end_time");

                    $maxStart = $slotStart->gt($appStart) ? $slotStart : $appStart;
                    $minEnd = $slotEnd->lt($appEnd) ? $slotEnd : $appEnd;

                    if ($maxStart->lt($minEnd)) {
                        $isOverlapping = true;
                        break;
                    }
                }

                if (!$isPast && !$isOverlapping) {
                    $slots[] = $slotStartStr;
                }

                $start->addMinutes(45);
            }
        }

        return $slots;
    }
}