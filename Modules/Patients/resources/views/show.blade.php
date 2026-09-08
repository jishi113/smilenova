@extends('layouts.admin')
@section('title', $patient->full_name . ' — Patient Profile')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3">
    <div>
        <div class="card" style="text-align:center;">
            <div class="avatar-circle">{{ strtoupper(substr($patient->first_name,0,1).substr($patient->last_name,0,1)) }}</div>
            <h2>{{ $patient->full_name }}</h2>
            <p style="color:#64748b;">{{ $patient->patient_code }}</p>
            <div style="text-align:left; margin-top:1rem;">
                <p><strong>Age:</strong> {{ $patient->age ?? '—' }}</p>
                <p><strong>Gender:</strong> {{ ucfirst($patient->gender ?? '—') }}</p>
                <p><strong>Blood:</strong> {{ $patient->blood_group ?? '—' }}</p>
                <p><strong>Phone:</strong> {{ $patient->phone }}</p>
                <p><strong>Email:</strong> {{ $patient->email ?? '—' }}</p>
            </div>
            @can('patients.edit')
                <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm" style="margin-top:1rem;">Edit Profile</a>
            @endcan
        </div>

        @if($patient->allergies)
            <div class="card" style="border-left:4px solid #dc2626;">
                <h3 style="color:#dc2626;">Allergies</h3>
                <p>{{ $patient->allergies }}</p>
            </div>
        @endif
    </div>

    <div>
        <div class="card">
            <h3>Additional Info</h3>
            <p><strong>Emergency Contact:</strong> {{ $patient->emergency_contact_name ?? '—' }} ({{ $patient->emergency_contact_phone ?? '—' }})</p>
            <p><strong>Address:</strong> {{ $patient->address ?? '—' }}</p>
            <p><strong>Notes:</strong> {{ $patient->notes ?? '—' }}</p>
            <p style="color:#94a3b8; margin-top:1rem;">Appointments, treatment history, and invoices will appear here once those modules are built.</p>
        </div>
    </div>
</div>
@endsection