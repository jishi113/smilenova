<?php

namespace Modules\Doctors\Http\Controllers;

use Modules\Doctors\Models\Doctor;
use Modules\Doctors\Models\Specialisation;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with(['user', 'specialisation'])->latest()->paginate(15);
        return view('doctors::index', compact('doctors'));
    }

    public function create()
    {
        $specialisations = Specialisation::all();
        return view('doctors::create', compact('specialisations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'specialisation_id' => ['required', 'exists:specialisations,id'],
            'registration_no' => ['required', 'string', 'unique:doctors,registration_no'],
            'qualification' => ['nullable', 'string', 'max:200'],
            'experience_years' => ['nullable', 'integer', 'min:0'],
            'bio' => ['nullable', 'string'],
            'consultation_fee' => ['nullable', 'numeric', 'min:0'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => \Hash::make('Smile@2026'),
        ]);
        $user->syncRoles(['dentist']);

        $doctor = Doctor::create([
            'user_id' => $user->id,
            'specialisation_id' => $data['specialisation_id'],
            'registration_no' => $data['registration_no'],
            'qualification' => $data['qualification'] ?? null,
            'experience_years' => $data['experience_years'] ?? 0,
            'bio' => $data['bio'] ?? null,
            'consultation_fee' => $data['consultation_fee'] ?? 0,
        ]);

        return redirect()->route('doctors.show', $doctor)->with('success', "Dr. {$user->name} added.");
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'specialisation', 'schedules']);
        return view('doctors::show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $specialisations = Specialisation::all();
        return view('doctors::edit', compact('doctor', 'specialisations'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'specialisation_id' => ['required', 'exists:specialisations,id'],
            'qualification' => ['nullable', 'string', 'max:200'],
            'experience_years' => ['nullable', 'integer', 'min:0'],
            'bio' => ['nullable', 'string'],
            'consultation_fee' => ['nullable', 'numeric', 'min:0'],
        ]);
        $data['is_active'] = $request->has('is_active');

        $doctor->update($data);

        return redirect()->route('doctors.show', $doctor)->with('success', 'Doctor updated.');
    }
}