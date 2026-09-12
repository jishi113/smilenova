@extends('layouts.admin')
@section('title', 'Appointments')
@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
        <h2>Appointments</h2>
        <div>
            <a href="{{ route('appointments.calendar') }}" class="btn btn-sm">Calendar View</a>
            @can('appointments.create')
                <a href="{{ route('appointments.create') }}" class="btn">+ Book Appointment</a>
            @endcan
        </div>
    </div>
    <form method="GET" style="display:flex; gap:.5rem; margin-bottom:1rem;">
        <input type="date" name="date" value="{{ request('date') }}">
        <select name="status">
            <option value="">All Status</option>
            @foreach(['pending','confirmed','in_progress','completed','cancelled','no_show'] as $s)
                <option value="{{ $s }}" @selected(request('status')==$s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <select name="doctor">
            <option value="">All Doctors</option>
            @foreach($doctors as $d)
                <option value="{{ $d->id }}" @selected(request('doctor')==$d->id)>Dr. {{ $d->user->name }}</option>
            @endforeach
        </select>
        <button class="btn btn-sm" type="submit">Filter</button>
    </form>
    <table>
        <thead><tr><th>Date</th><th>Time</th><th>Patient</th><th>Doctor</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse($appointments as $appt)
                <tr>
                    <td>{{ $appt->appointment_date->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($appt->start_time)->format('h:i A') }}</td>
                    <td>{{ $appt->patient->full_name }}</td>
                    <td>Dr. {{ $appt->doctor->user->name }}</td>
                    <td><span class="badge">{{ ucfirst($appt->status) }}</span></td>
                    <td><a href="{{ route('appointments.show', $appt) }}" class="btn btn-sm">View</a></td>
                </tr>
            @empty
                <tr><td colspan="6">No appointments found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $appointments->links() }}</div>
</div>
@endsection