@extends('layouts.admin')

@section('title', 'Book Appointment')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.appointments.index') }}" class="p-2 rounded-lg hover:bg-slate-100">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Book New Appointment</h2>
            <p class="text-sm text-slate-500">Schedule a new appointment for a patient</p>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.appointments.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Left: Appointment Details --}}
            <div class="card">
                <h3 class="font-semibold text-slate-800 mb-4">Appointment Details</h3>
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Patient <span class="text-red-500">*</span></label>
                        <select name="patient_id" required class="form-input">
                            <option value="">Select patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->full_name }} ({{ $patient->patient_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="form-label">Doctor <span class="text-red-500">*</span></label>
                        <select name="doctor_id" required class="form-input">
                            <option value="">Select doctor</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    Dr. {{ $doctor->user->name ?? 'N/A' }} ({{ $doctor->specialisation->name ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="form-label">Service</label>
                        <select name="service_id" class="form-input">
                            <option value="">Select service (optional)</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} — ₹{{ number_format($service->price, 0) }} ({{ $service->duration }} min)
                                </option>
                            @endforeach
                        </select>
                        @error('service_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Right: Date & Time --}}
            <div class="card">
                <h3 class="font-semibold text-slate-800 mb-4">Date & Time</h3>
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Appointment Date <span class="text-red-500">*</span></label>
                        <input type="date" name="appointment_date" value="{{ old('appointment_date', date('Y-m-d')) }}"
                               required min="{{ date('Y-m-d') }}" class="form-input">
                        @error('appointment_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="form-label">Start Time <span class="text-red-500">*</span></label>
                        <input type="time" name="start_time" value="{{ old('start_time', '10:00') }}" required class="form-input">
                        @error('start_time') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="form-label">Reason / Notes</label>
                        <textarea name="reason" rows="4" class="form-input" placeholder="Reason for appointment...">{{ old('reason') }}</textarea>
                        @error('reason') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Book Appointment
            </button>
        </div>

    </form>

</div>
@endsection