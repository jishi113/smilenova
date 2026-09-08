<?php

namespace Modules\Patients\Http\Controllers;

use Modules\Patients\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $patients = Patient::query()
            ->when($request->search, fn($q) => $q->where(fn($q2) => $q2
                ->where('first_name', 'like', "%{$request->search}%")
                ->orWhere('last_name', 'like', "%{$request->search}%")
                ->orWhere('phone', 'like', "%{$request->search}%")
                ->orWhere('patient_code', 'like', "%{$request->search}%")))
            ->when($request->gender, fn($q) => $q->where('gender', $request->gender))
            ->latest()->paginate(15)->withQueryString();

        return view('patients::index', compact('patients'));
    }

    public function create()
    {
        return view('patients::create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'blood_group' => ['nullable', 'string', 'max:5'],
            'address' => ['nullable', 'string'],
            'emergency_contact_name' => ['nullable', 'string', 'max:100'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
            'allergies' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $data['patient_code'] = Patient::generateCode();
        $data['registered_at'] = now();
        $patient = Patient::create($data);

        return redirect()->route('patients.show', $patient)
            ->with('success', "Patient {$patient->full_name} registered. Code: {$patient->patient_code}");
    }

    public function show(Patient $patient)
{
    $upcomingAppts = collect();

    return view('patients::show', compact('patient', 'upcomingAppts'));
}

    public function edit(Patient $patient)
    {
        return view('patients::edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'blood_group' => ['nullable', 'string', 'max:5'],
            'address' => ['nullable', 'string'],
            'emergency_contact_name' => ['nullable', 'string', 'max:100'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
            'allergies' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $patient->update($data);

        return redirect()->route('patients.show', $patient)->with('success', 'Patient updated.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient archived.');
    }
}