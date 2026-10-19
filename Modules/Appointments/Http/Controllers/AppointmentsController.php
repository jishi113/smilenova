<?php

namespace Modules\Appointments\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Appointments\Models\Appointment;
use Modules\Patients\Models\Patient;
use Modules\Doctors\Models\Doctor;
use Modules\Billing\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentsController extends Controller
{
    public function index(Request $request)
    {
        $appointments = Appointment::with(['patient', 'doctor.user', 'service'])
            ->when($request->date, function ($q) use ($request) {
                $q->whereDate('appointment_date', $request->date);
            })
            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->doctor, function ($q) use ($request) {
                $q->where('doctor_id', $request->doctor);
            })
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(20)
            ->withQueryString();

        $doctors = Doctor::with('user')->where('is_active', true)->get();

        return view('appointments::index', compact('appointments', 'doctors'));
    }

    public function create()
    {
        $patients = Patient::orderBy('first_name')->get();
        $doctors = Doctor::with('user')->where('is_active', true)->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();

        return view('appointments::create', compact('patients', 'doctors', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        // Calculate end time from service duration or default 30 min
        $service = $validated['service_id'] ? Service::find($validated['service_id']) : null;
        $duration = $service?->duration ?? 30;
        $endTime = Carbon::parse($validated['start_time'])->addMinutes($duration)->format('H:i');

        // Check for conflict
        $conflict = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('start_time', $validated['start_time'])
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->exists();

        if ($conflict) {
            return back()->withErrors(['start_time' => 'This slot is already booked.'])->withInput();
        }

        $validated['end_time'] = $endTime;
        $validated['booked_by'] = auth()->id();
        $validated['status'] = 'confirmed';

        $appointment = Appointment::create($validated);

        return redirect()
            ->route('admin.appointments.show', $appointment)
            ->with('success', 'Appointment booked successfully.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor.user', 'service']);
        return view('appointments::show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::orderBy('first_name')->get();
        $doctors = Doctor::with('user')->where('is_active', true)->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();

        return view('appointments::edit', compact('appointment', 'patients', 'doctors', 'services'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'appointment_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'status' => ['required', 'in:pending,confirmed,in_progress,completed,cancelled,no_show'],
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $service = $validated['service_id'] ? Service::find($validated['service_id']) : null;
        $duration = $service?->duration ?? 30;
        $validated['end_time'] = Carbon::parse($validated['start_time'])->addMinutes($duration)->format('H:i');

        $appointment->update($validated);

        return redirect()
            ->route('admin.appointments.show', $appointment)
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,in_progress,completed,cancelled,no_show'],
            'cancellation_reason' => ['nullable', 'string', 'max:255'],
        ]);

        $appointment->update([
            'status' => $validated['status'],
            'cancellation_reason' => $validated['cancellation_reason'] ?? null,
        ]);

        return back()->with('success', 'Status updated to ' . ucfirst(str_replace('_', ' ', $validated['status'])));
    }

    public function calendar()
    {
        return view('appointments::coming-soon', ['title' => 'Calendar']);
    }
}