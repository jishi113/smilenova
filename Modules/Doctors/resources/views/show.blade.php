@extends('layouts.admin')
@section('title', 'Dr. ' . $doctor->user->name)
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3">
    <div class="card" style="text-align:center;">
        <div class="avatar-circle">{{ strtoupper(substr($doctor->user->name,0,2)) }}</div>
        <h2>Dr. {{ $doctor->user->name }}</h2>
        <p style="color:#64748b;">{{ $doctor->specialisation->name ?? '—' }}</p>
        <div style="text-align:left; margin-top:1rem;">
            <p><strong>Reg No:</strong> {{ $doctor->registration_no }}</p>
            <p><strong>Qualification:</strong> {{ $doctor->qualification ?? '—' }}</p>
            <p><strong>Experience:</strong> {{ $doctor->experience_years }} yrs</p>
            <p><strong>Fee:</strong> ₹{{ number_format($doctor->consultation_fee, 2) }}</p>
            <p><strong>Status:</strong> {{ $doctor->is_active ? 'Active' : 'Inactive' }}</p>
        </div>
        @can('doctors.edit')
            <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-sm" style="margin-top:1rem;">Edit</a>
            <a href="{{ route('doctors.schedules.index', $doctor) }}" class="btn btn-sm" style="margin-top:1rem;">Manage Schedule</a>
        @endcan
    </div>

    <div class="card">
        <h3>Bio</h3>
        <p>{{ $doctor->bio ?? 'No bio added.' }}</p>
        <h3>Weekly Schedule</h3>
        @forelse($doctor->schedules as $sch)
            @php $days=['Sun','Mon','Tue','Wed','Thu','Fri','Sat']; @endphp
            <p>{{ $days[$sch->day_of_week] }}: {{ $sch->is_active ? "$sch->start_time - $sch->end_time ({$sch->slot_duration}min slots)" : 'Off' }}</p>
        @empty
            <p style="color:#94a3b8;">No schedule set yet.</p>
        @endforelse
    </div>
</div>
@endsection