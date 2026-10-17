@extends('layouts.admin')

@section('title', 'Doctors')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Doctors</h2>
            <p class="text-sm text-slate-500">Manage all clinic doctors</p>
        </div>
        @can('doctors.create')
            <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Doctor
            </a>
        @endcan
    </div>

    {{-- Filters --}}
    <div class="card">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="sm:col-span-2">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search by name, email, or registration no..."
                       class="form-input">
            </div>
            <div class="flex gap-2">
                <select name="specialisation" class="form-input">
                    <option value="">All Specialisations</option>
                    @foreach($specialisations as $spec)
                        <option value="{{ $spec->id }}" {{ request('specialisation') == $spec->id ? 'selected' : '' }}>
                            {{ $spec->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary">Filter</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Reg. No</th>
                        <th>Doctor</th>
                        <th>Specialisation</th>
                        <th>Experience</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($doctors as $doctor)
                        <tr>
                            <td>
                                <span class="font-mono text-xs font-medium text-primary-600 bg-primary-50 px-2 py-1 rounded">
                                    {{ $doctor->registration_no }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white text-xs font-semibold">
                                        {{ strtoupper(substr($doctor->user->name ?? 'D', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-800">Dr. {{ $doctor->user->name ?? 'N/A' }}</p>
                                        <p class="text-xs text-slate-500">{{ $doctor->user->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-purple">{{ $doctor->specialisation->name ?? 'N/A' }}</span>
                            </td>
                            <td class="text-sm">{{ $doctor->experience_years }} yrs</td>
                            <td class="text-sm font-medium">₹{{ number_format($doctor->consultation_fee, 0) }}</td>
                            <td>
                                @if($doctor->is_active)
                                    <span class="badge badge-green">Active</span>
                                @else
                                    <span class="badge badge-gray">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-2">
                                    @can('doctors.view')
                                        <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-sm btn-secondary" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                    @endcan
                                    @can('doctors.edit')
                                        <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-sm btn-secondary" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <p class="text-slate-600 font-medium">No doctors yet</p>
                                    <p class="text-slate-400 text-sm mt-1">Click "Add Doctor" to create the first one</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($doctors->hasPages())
            <div class="px-4 py-3 border-t border-slate-200">
                {{ $doctors->links() }}
            </div>
        @endif
    </div>

</div>
@endsection