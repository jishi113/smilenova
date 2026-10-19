@extends('layouts.admin')

@section('title', 'Appointments')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Appointments</h2>
            <p class="text-sm text-slate-500">Manage all clinic appointments</p>
        </div>
        @can('appointments.create')
            <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Book Appointment
            </a>
        @endcan
    </div>

    {{-- Filters --}}
    <div class="card">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <input type="date" name="date" value="{{ request('date') }}" class="form-input">
            </div>
            <div>
                <select name="status" class="form-input">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>No Show</option>
                </select>
            </div>
            <div>
                <select name="doctor" class="form-input">
                    <option value="">All Doctors</option>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ request('doctor') == $doc->id ? 'selected' : '' }}>Dr. {{ $doc->user->name ?? 'N/A' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-secondary flex-1">Filter</button>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">Clear</a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Service</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                        <tr>
                            <td>
                                <p class="font-medium text-slate-800 text-sm">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}</p>
                                <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($appt->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appt->end_time)->format('h:i A') }}</p>
                            </td>
                            <td>
                                <p class="font-medium text-slate-800 text-sm">{{ $appt->patient->full_name ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-500">{{ $appt->patient->phone ?? '' }}</p>
                            </td>
                            <td class="text-sm">Dr. {{ $appt->doctor->user->name ?? 'N/A' }}</td>
                            <td class="text-sm">{{ $appt->service->name ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $appt->status_badge }}">{{ ucfirst(str_replace('_', ' ', $appt->status)) }}</span>
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.appointments.show', $appt) }}" class="btn btn-sm btn-secondary" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    @can('appointments.edit')
                                        <a href="{{ route('admin.appointments.edit', $appt) }}" class="btn btn-sm btn-secondary" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <p class="text-slate-600 font-medium">No appointments yet</p>
                                    <p class="text-slate-400 text-sm mt-1">Click "Book Appointment" to create the first one</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($appointments->hasPages())
            <div class="px-4 py-3 border-t border-slate-200">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>

</div>
@endsection