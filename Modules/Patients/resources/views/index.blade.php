@extends('layouts.admin')

@section('title', 'Patients')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Patients</h2>
            <p class="text-sm text-slate-500">Manage all clinic patients</p>
        </div>
        @can('patients.create')
            <a href="{{ route('admin.patients.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Patient
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
                       placeholder="Search by name, phone, or code..."
                       class="form-input">
            </div>
            <div class="flex gap-2">
                <select name="gender" class="form-input">
                    <option value="">All Genders</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
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
                        <th>Patient Code</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Registered</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>
                                <span class="font-mono text-xs font-medium text-primary-600 bg-primary-50 px-2 py-1 rounded">
                                    {{ $patient->patient_code }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white text-xs font-semibold">
                                        {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-800">{{ $patient->full_name }}</p>
                                        <p class="text-xs text-slate-500">{{ $patient->email ?? 'No email' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-sm">{{ $patient->phone }}</td>
                            <td>
                                @if($patient->gender)
                                    <span class="badge badge-blue">{{ ucfirst($patient->gender) }}</span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="text-sm">{{ $patient->age ? $patient->age . ' yrs' : '—' }}</td>
                            <td class="text-sm text-slate-500">
                                {{ $patient->registered_at ? \Carbon\Carbon::parse($patient->registered_at)->format('M d, Y') : '—' }}
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-2">
                                    @can('patients.view')
                                        <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-sm btn-secondary" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                    @endcan
                                    @can('patients.edit')
                                        <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-sm btn-secondary" title="Edit">
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
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <p class="text-slate-600 font-medium">No patients yet</p>
                                    <p class="text-slate-400 text-sm mt-1">Click "Add Patient" to create the first one</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($patients->hasPages())
            <div class="px-4 py-3 border-t border-slate-200">
                {{ $patients->links() }}
            </div>
        @endif
    </div>

</div>
@endsection