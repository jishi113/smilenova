@extends('layouts.admin')

@section('title', 'Dr. ' . ($doctor->user->name ?? 'Doctor'))

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.doctors.index') }}" class="p-2 rounded-lg hover:bg-slate-100">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="text-xl font-semibold text-slate-800">Doctor Profile</h2>
                <p class="text-sm text-slate-500">Reg. No: <span class="font-mono text-primary-600">{{ $doctor->registration_no }}</span></p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @can('doctors.edit')
                <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </a>
            @endcan

            @can('doctors.delete')
                <button onclick="document.getElementById('delete-modal').classList.remove('hidden')" class="btn btn-danger">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete
                </button>
            @endcan
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Profile --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="card text-center">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">
                    {{ strtoupper(substr($doctor->user->name ?? 'D', 0, 1)) }}
                </div>
                <h3 class="text-lg font-bold text-slate-800">Dr. {{ $doctor->user->name ?? 'N/A' }}</h3>
                <p class="text-xs text-primary-600 font-medium mt-1">{{ $doctor->specialisation->name ?? 'N/A' }}</p>
                <p class="text-xs text-slate-500 font-mono mt-2">{{ $doctor->registration_no }}</p>

                @if($doctor->is_active)
                    <span class="badge badge-green mt-3">Active</span>
                @else
                    <span class="badge badge-gray mt-3">Inactive</span>
                @endif
            </div>

            @if($doctor->bio)
                <div class="card">
                    <h4 class="font-semibold text-slate-800 text-sm mb-2">About</h4>
                    <p class="text-sm text-slate-600">{{ $doctor->bio }}</p>
                </div>
            @endif
        </div>

        {{-- Right: Details --}}
        <div class="lg:col-span-2">
            <div class="card">
                <h3 class="font-semibold text-slate-800 mb-4">Professional Details</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Specialisation</p>
                        <p class="text-sm font-medium text-slate-800 mt-1">{{ $doctor->specialisation->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Experience</p>
                        <p class="text-sm font-medium text-slate-800 mt-1">{{ $doctor->experience_years }} years</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Qualification</p>
                        <p class="text-sm font-medium text-slate-800 mt-1">{{ $doctor->qualification ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Consultation Fee</p>
                        <p class="text-sm font-medium text-slate-800 mt-1">₹{{ number_format($doctor->consultation_fee, 0) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Email</p>
                        <p class="text-sm font-medium text-slate-800 mt-1">{{ $doctor->user->email ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Phone</p>
                        <p class="text-sm font-medium text-slate-800 mt-1">{{ $doctor->user->phone ?? '—' }}</p>
                    </div>
                </div>

                <div class="border-t border-slate-100 mt-6 pt-4">
                    <p class="text-xs text-slate-500 uppercase">Working Hours</p>
                    <p class="text-sm font-medium text-slate-800 mt-1">Mon-Sat: 10:00 AM - 7:00 PM</p>
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
                    <h3 class="text-lg font-semibold text-slate-800">Delete Doctor?</h3>
                    <p class="text-sm text-slate-500">This will permanently delete the doctor and their user account.</p>
                </div>
            </div>

            <div class="bg-slate-50 rounded-lg p-3 mb-6">
                <p class="text-sm font-medium text-slate-800">Dr. {{ $doctor->user->name ?? 'N/A' }}</p>
                <p class="text-xs text-slate-500 font-mono">{{ $doctor->registration_no }}</p>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button onclick="document.getElementById('delete-modal').classList.add('hidden')" class="btn btn-secondary">
                    Cancel
                </button>
                <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="inline">
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