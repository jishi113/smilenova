<?php

namespace Modules\Appointments\Http\Controllers;

use Modules\Appointments\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $startDate = \Carbon\Carbon::parse($month . '-01')->startOfMonth()->startOfWeek();
        $endDate = \Carbon\Carbon::parse($month . '-01')->endOfMonth()->endOfWeek();

        $query = Appointment::with(['patient', 'doctor.user'])
            ->whereBetween('appointment_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->whereNotIn('status', ['cancelled', 'no_show']);

        if (auth()->user()->hasRole('dentist')) {
            $query->where('doctor_id', auth()->user()->doctor?->id);
        }

        $appointments = $query->get()->groupBy(fn($a) => $a->appointment_date->toDateString());

        return view('appointments::calendar', compact('appointments', 'startDate', 'endDate', 'month'));
    }
}