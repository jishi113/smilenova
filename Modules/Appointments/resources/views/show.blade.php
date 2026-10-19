@extends('layouts.admin')

@section('title', 'Appointment #' . $appointment->id)

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.appointments.index') }}" class="p-2 rounded-lg hover:bg-slate-100">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="text-xl font-semibold text-slate-800">Appointment Details</h2>
                <p class="text-sm text-slate-500">ID: #{{ $appointment->id }}</p>
            </div>
        </div>
       <div class="flex items-center gap-2">
    @can('appointments.edit')
        <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit
        </a>
    @endcan

    @can('appointments.delete')
        <button onclick="document.getElementById('delete-modal').classList.remove('hidden')" class="btn btn-danger">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Delete
        </button>
    @endcan
</div>
    </div>

    {{-- Status Banner --}}
    <div class="card">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full {{ $appointment->status === 'confirmed' ? 'bg-emerald-100 text-emerald-600' : ($appointment->status === 'completed' ? 'bg-blue-100 text-blue-600' : ($appointment->status === 'cancelled' ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600')) }} flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase">Current Status</p>
                    <p class="text-lg font-semibold text-slate-800">{{ ucfirst(str_replace('_', ' ', $appointment->status)) }}</p>
                </div>
            </div>

            {{-- Status Update Buttons --}}
            @can('appointments.edit')
                <div class="flex gap-2">
                    @if($appointment->status === 'pending')
                        <form action="{{ route('admin.appointments.status', $appointment) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" class="btn btn-success btn-sm">Confirm</button>
                        </form>
                    @endif
                    @if($appointment->status === 'confirmed')
                        <form action="{{ route('admin.appointments.status', $appointment) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="status" value="in_progress">
                            <button type="submit" class="btn btn-primary btn-sm">Start</button>
                        </form>
                    @endif
                    @if($appointment->status === 'in_progress')
                        <form action="{{ route('admin.appointments.status', $appointment) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-success btn-sm">Complete</button>
                        </form>
                    @endif
                    @if(!in_array($appointment->status, ['cancelled', 'completed', 'no_show']))
                        <button onclick="document.getElementById('cancel-modal').classList.remove('hidden')" class="btn btn-danger btn-sm">Cancel</button>
                    @endif
                </div>
            @endcan
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Patient & Doctor --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Patient --}}
            <div class="card">
                <h3 class="font-semibold text-slate-800 mb-3 text-sm uppercase tracking-wider">Patient</h3>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($appointment->patient->first_name ?? 'P', 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-medium text-slate-800">{{ $appointment->patient->full_name ?? 'N/A' }}</p>
                        <p class="text-xs text-slate-500">{{ $appointment->patient->patient_code ?? '' }}</p>
                    </div>
                </div>
                <div class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Phone</span>
                        <span class="font-medium">{{ $appointment->patient->phone ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Email</span>
                        <span class="font-medium text-xs">{{ $appointment->patient->email ?? '—' }}</span>
                    </div>
                </div>
            </div>

            {{-- Doctor --}}
            <div class="card">
                <h3 class="font-semibold text-slate-800 mb-3 text-sm uppercase tracking-wider">Doctor</h3>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($appointment->doctor->user->name ?? 'D', 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-medium text-slate-800">Dr. {{ $appointment->doctor->user->name ?? 'N/A' }}</p>
                        <p class="text-xs text-slate-500">{{ $appointment->doctor->specialisation->name ?? '' }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right: Appointment Info --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="card">
                <h3 class="font-semibold text-slate-800 mb-4">Appointment Information</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Date</p>
                        <p class="text-sm font-medium text-slate-800 mt-1">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Time</p>
                        <p class="text-sm font-medium text-slate-800 mt-1">{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Service</p>
                        <p class="text-sm font-medium text-slate-800 mt-1">{{ $appointment->service->name ?? 'General Checkup' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Service Fee</p>
                        <p class="text-sm font-medium text-slate-800 mt-1">₹{{ number_format($appointment->service->price ?? 0, 0) }}</p>
                    </div>
                </div>

                @if($appointment->reason)
                    <div class="border-t border-slate-100 mt-4 pt-4">
                        <p class="text-xs text-slate-500 uppercase mb-1">Reason</p>
                        <p class="text-sm text-slate-700">{{ $appointment->reason }}</p>
                    </div>
                @endif

                @if($appointment->cancellation_reason)
                    <div class="border-t border-slate-100 mt-4 pt-4">
                        <p class="text-xs text-red-500 uppercase mb-1">Cancellation Reason</p>
                        <p class="text-sm text-red-700">{{ $appointment->cancellation_reason }}</p>
                    </div>
                @endif

                <div class="border-t border-slate-100 mt-4 pt-4">
                    <p class="text-xs text-slate-500 uppercase mb-1">Booked On</p>
                    <p class="text-sm text-slate-700">{{ $appointment->created_at->format('M d, Y H:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Cancel Modal --}}
<div id="cancel-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="document.getElementById('cancel-modal').classList.add('hidden')"></div>

        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-800">Cancel Appointment?</h3>
                    <p class="text-sm text-slate-500">Please provide a reason for cancellation.</p>
                </div>
            </div>

            <form action="{{ route('admin.appointments.status', $appointment) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="cancelled">
                <div class="mb-4">
                    <label class="form-label">Cancellation Reason</label>
                    <textarea name="cancellation_reason" rows="3" required class="form-input" placeholder="Enter reason..."></textarea>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button type="button" onclick="document.getElementById('cancel-modal').classList.add('hidden')" class="btn btn-secondary">
                        Keep Appointment
                    </button>
                    <button type="submit" class="btn btn-danger">
                        Cancel Appointment
                    </button>
                </div>
            </form>
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
                    <h3 class="text-lg font-semibold text-slate-800">Delete Appointment?</h3>
                    <p class="text-sm text-slate-500">This will permanently delete the appointment.</p>
                </div>
            </div>

            <div class="bg-slate-50 rounded-lg p-3 mb-6">
                <p class="text-sm font-medium text-slate-800">#{{ $appointment->id }} — {{ $appointment->patient->full_name ?? 'N/A' }}</p>
                <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}</p>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button onclick="document.getElementById('delete-modal').classList.add('hidden')" class="btn btn-secondary">
                    Cancel
                </button>
                <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="inline">
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