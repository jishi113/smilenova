<?php

namespace Modules\Appointments\Http\Controllers;

use Modules\Appointments\Models\Appointment;
use Modules\Patients\Models\Patient;
use Modules\Doctors\Models\Doctor;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor.user', 'service']);

        if (auth()->user()->hasRole('dentist')) {
            $doctor = auth()->user()->doctor;
            $query->where('doctor_id', $doctor?->id);
        }

        $appointments = $query
            ->when($request->date, fn($q) => $q->whereDate('appointment_date', $request->date))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->doctor, fn($q) => $q->where('doctor_id', $request->doctor))
            ->orderBy('appointment_date')->orderBy('start_time')
            ->paginate(20)->withQueryString();

        $doctors = Doctor::where('is_active', true)->with('user')->get();

        return view('appointments::index', compact('appointments', 'doctors'));
    }

    public function create()
    {
        $doctors = Doctor::where('is_active', true)->with(['user', 'specialisation'])->get();
        $patients = Patient::where('is_active', true)->orderBy('first_name')->get();
        $services = Service::where('is_active', true)->orderBy('name')->get();

        return view('appointments::create', compact('doctors', 'patients', 'services'));
    }

    public function getSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
            'date' => ['required', 'date'],
        ]);

        $doctor = Doctor::with('schedules')->findOrFail($request->doctor_id);
        $slots = $doctor->getAvailableSlotsFor(\Carbon\Carbon::parse($request->date));

        return response()->json(['success' => true, 'slots' => $slots]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'appointment_date' => ['required', 'date'],
            'start_time' => ['required'],
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $service = $validated['service_id'] ? Service::find($validated['service_id']) : null;
        $duration = $service?->duration ?? 30;
        $endTime = \Carbon\Carbon::parse($validated['start_time'])->addMinutes($duration)->format('H:i');

        $conflict = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('start_time', $validated['start_time'])
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->exists();

        if ($conflict) {
            return back()->withErrors(['start_time' => 'This slot is no longer available.'])->withInput();
        }

        $appointment = Appointment::create(array_merge($validated, [
            'end_time' => $endTime,
            'booked_by' => auth()->id(),
            'status' => 'confirmed',
        ]));

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment booked successfully.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor.user', 'service', 'treatment']);
        return view('appointments::show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => ['required', 'in:confirmed,in_progress,completed,cancelled,no_show'],
            'cancellation_reason' => ['required_if:status,cancelled', 'nullable', 'string'],
        ]);

        $appointment->update([
            'status' => $request->status,
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        return back()->with('success', 'Appointment status updated.');
    }

    public function recordTreatment(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'diagnosis' => ['required', 'string'],
            'treatment_done' => ['required', 'string'],
            'prescription' => ['nullable', 'string'],
            'follow_up_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $doctorId = auth()->user()->doctor?->id ?? $appointment->doctor_id;

        $appointment->treatment()->updateOrCreate(
            ['appointment_id' => $appointment->id],
            array_merge($validated, ['doctor_id' => $doctorId, 'patient_id' => $appointment->patient_id])
        );

        $appointment->update(['status' => 'completed']);

        return back()->with('success', 'Treatment recorded and appointment completed.');
    }
}