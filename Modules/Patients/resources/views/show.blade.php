@extends('layouts.admin')

@section('title', $patient->full_name . ' — Patient Profile')

@section('content')
<div class="space-y-6">

    {{-- Header with back button --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.patients.index') }}" class="p-2 rounded-lg hover:bg-slate-100">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="text-xl font-semibold text-slate-800">Patient Profile</h2>
                <p class="text-sm text-slate-500">Patient Code: <span class="font-mono text-primary-600">{{ $patient->patient_code }}</span></p>
            </div>
        </div>
       <div class="flex items-center gap-2">
    @can('patients.edit')
        <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit Patient
        </a>
    @endcan

    @can('patients.delete')
        <button onclick="document.getElementById('delete-modal').classList.remove('hidden')" class="btn btn-danger">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Delete
        </button>
    @endcan
</div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: Patient Info Card --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Main profile --}}
            <div class="card text-center">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">
                    {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                </div>
                <h3 class="text-lg font-bold text-slate-800">{{ $patient->full_name }}</h3>
                <p class="text-xs text-slate-500 font-mono mt-1">{{ $patient->patient_code }}</p>

                <div class="mt-6 space-y-3 text-left">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Age</span>
                        <span class="font-medium text-slate-800">{{ $patient->age ? $patient->age . ' yrs' : '—' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Gender</span>
                        <span class="font-medium text-slate-800">{{ ucfirst($patient->gender ?? '—') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Blood Group</span>
                        <span class="font-medium text-slate-800">{{ $patient->blood_group ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Phone</span>
                        <span class="font-medium text-slate-800">{{ $patient->phone }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Email</span>
                        <span class="font-medium text-slate-800 text-xs">{{ $patient->email ?? '—' }}</span>
                    </div>
                </div>
            </div>

            {{-- Allergies --}}
            @if($patient->allergies)
                <div class="card border-l-4 border-red-500">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <h4 class="font-semibold text-red-700 text-sm">Allergies</h4>
                    </div>
                    <p class="text-sm text-red-800">{{ $patient->allergies }}</p>
                </div>
            @endif

            {{-- Address --}}
            @if($patient->address)
                <div class="card">
                    <h4 class="font-semibold text-slate-800 text-sm mb-2">Address</h4>
                    <p class="text-sm text-slate-600">{{ $patient->address }}</p>
                </div>
            @endif

            {{-- Emergency Contact --}}
            @if($patient->emergency_contact_name || $patient->emergency_contact_phone)
                <div class="card">
                    <h4 class="font-semibold text-slate-800 text-sm mb-3">Emergency Contact</h4>
                    <div class="space-y-2 text-sm">
                        @if($patient->emergency_contact_name)
                            <div class="flex justify-between">
                                <span class="text-slate-500">Name</span>
                                <span class="font-medium">{{ $patient->emergency_contact_name }}</span>
                            </div>
                        @endif
                        @if($patient->emergency_contact_phone)
                            <div class="flex justify-between">
                                <span class="text-slate-500">Phone</span>
                                <span class="font-medium">{{ $patient->emergency_contact_phone }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>

        {{-- RIGHT: Appointments + Treatments --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Appointments --}}
            <div class="card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Appointment History
                    </h3>
                    <span class="badge badge-gray">{{ $patient->appointments->count() }} total</span>
                </div>

                @forelse($patient->appointments as $appt)
                    <div class="flex items-center gap-4 p-3 border-b border-slate-100 last:border-0">
                        <div class="flex-shrink-0 w-14 text-center">
                            <p class="text-xs font-semibold text-primary-600 uppercase">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M') }}</p>
                            <p class="text-lg font-bold text-slate-800">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('d') }}</p>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-slate-800 text-sm">Dr. {{ $appt->doctor->user->name ?? 'N/A' }}</p>
                            <p class="text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($appt->start_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($appt->end_time)->format('h:i A') }}
                            </p>
                        </div>
                        <span class="badge {{ $appt->status_badge }}">{{ ucfirst(str_replace('_', ' ', $appt->status)) }}</span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-sm text-slate-400">No appointments yet</p>
                    </div>
                @endforelse
            </div>

            {{-- Medical Notes --}}
            @if($patient->notes)
                <div class="card">
                    <h3 class="font-semibold text-slate-800 mb-2">Medical Notes</h3>
                    <p class="text-sm text-slate-600">{{ $patient->notes }}</p>
                </div>
            @endif

            {{-- Registration Info --}}
            <div class="card">
                <h3 class="font-semibold text-slate-800 mb-3">Registration Info</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-slate-500 text-xs">Registered On</p>
                        <p class="font-medium text-slate-800">
                            {{ $patient->registered_at ? \Carbon\Carbon::parse($patient->registered_at)->format('M d, Y H:i A') : '—' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs">Status</p>
                        @if($patient->is_active)
                            <span class="badge badge-green">Active</span>
                        @else
                            <span class="badge badge-gray">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
{{-- Delete Confirmation Modal --}}
<div id="delete-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="document.getElementById('delete-modal').classList.add('hidden')"></div>

        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-800">Delete Patient?</h3>
                    <p class="text-sm text-slate-500">This will soft-delete the patient record.</p>
                </div>
            </div>

            <div class="bg-slate-50 rounded-lg p-3 mb-6">
                <p class="text-sm font-medium text-slate-800">{{ $patient->full_name }}</p>
                <p class="text-xs text-slate-500 font-mono">{{ $patient->patient_code }}</p>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button onclick="document.getElementById('delete-modal').classList.add('hidden')" class="btn btn-secondary">
                    Cancel
                </button>
                <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection