<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Patients\Models\Patient;
use Modules\Doctors\Models\Doctor;
use Modules\Appointments\Models\Appointment;
use Modules\Billing\Models\Payment;
use Modules\Billing\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'today_completed' => Appointment::whereDate('appointment_date', today())->where('status', 'completed')->count(),
            'total_patients' => Patient::count(),
            'new_patients_month' => Patient::whereMonth('registered_at', now()->month)->count(),
            'revenue_today' => Payment::whereDate('paid_at', today())->sum('amount'),
            'revenue_month' => Payment::whereMonth('paid_at', now()->month)->sum('amount'),
            'outstanding' => Invoice::whereIn('status', ['sent', 'partial', 'overdue'])->sum('total'),
        ];

        return view('dashboard::index', compact('user', 'stats'));
    }
}