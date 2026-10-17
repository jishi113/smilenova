<?php

namespace Modules\Doctors\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Doctors\Models\Doctor;
use Modules\Doctors\Models\Specialisation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorsController extends Controller
{
    public function index(Request $request)
    {
        $doctors = Doctor::with(['user', 'specialisation'])
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('user', function ($q2) use ($request) {
                    $q2->where('name', 'like', "%{$request->search}%")
                       ->orWhere('email', 'like', "%{$request->search}%");
                })->orWhere('registration_no', 'like', "%{$request->search}%");
            })
            ->when($request->specialisation, function ($q) use ($request) {
                $q->where('specialisation_id', $request->specialisation);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $specialisations = Specialisation::orderBy('name')->get();

        return view('doctors::index', compact('doctors', 'specialisations'));
    }

    public function create()
    {
        $specialisations = Specialisation::orderBy('name')->get();
        return view('doctors::create', compact('specialisations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'specialisation_id' => ['required', 'exists:specialisations,id'],
            'registration_no' => ['required', 'string', 'max:50', 'unique:doctors,registration_no'],
            'qualification' => ['nullable', 'string', 'max:200'],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:60'],
            'bio' => ['nullable', 'string'],
            'consultation_fee' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);
        $user->assignRole('dentist');

        Doctor::create([
            'user_id' => $user->id,
            'specialisation_id' => $validated['specialisation_id'],
            'registration_no' => $validated['registration_no'],
            'qualification' => $validated['qualification'] ?? null,
            'experience_years' => $validated['experience_years'] ?? 0,
            'bio' => $validated['bio'] ?? null,
            'consultation_fee' => $validated['consultation_fee'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', "Dr. {$validated['name']} added successfully.");
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'specialisation', 'schedules']);
        return view('doctors::show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $specialisations = Specialisation::orderBy('name')->get();
        return view('doctors::edit', compact('doctor', 'specialisations'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,' . $doctor->user_id],
            'phone' => ['nullable', 'string', 'max:20'],
            'specialisation_id' => ['required', 'exists:specialisations,id'],
            'registration_no' => ['required', 'string', 'max:50', 'unique:doctors,registration_no,' . $doctor->id],
            'qualification' => ['nullable', 'string', 'max:200'],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:60'],
            'bio' => ['nullable', 'string'],
            'consultation_fee' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $doctor->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        $doctor->update([
            'specialisation_id' => $validated['specialisation_id'],
            'registration_no' => $validated['registration_no'],
            'qualification' => $validated['qualification'] ?? null,
            'experience_years' => $validated['experience_years'] ?? 0,
            'bio' => $validated['bio'] ?? null,
            'consultation_fee' => $validated['consultation_fee'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()
            ->route('admin.doctors.show', $doctor)
            ->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete();
        $doctor->delete();

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor deleted successfully.');
    }
}