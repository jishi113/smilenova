@extends('layouts.admin')
@section('title', 'Doctors')
@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
        <h2>Doctors</h2>
        @can('doctors.create')
            <a href="{{ route('doctors.create') }}" class="btn">+ New Doctor</a>
        @endcan
    </div>
    <table>
        <thead><tr><th>Name</th><th>Specialisation</th><th>Reg. No</th><th>Fee</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse($doctors as $doctor)
                <tr>
                    <td><a href="{{ route('doctors.show', $doctor) }}">Dr. {{ $doctor->user->name }}</a></td>
                    <td>{{ $doctor->specialisation->name ?? '—' }}</td>
                    <td>{{ $doctor->registration_no }}</td>
                    <td>₹{{ number_format($doctor->consultation_fee, 2) }}</td>
                    <td><span class="badge">{{ $doctor->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td><a href="{{ route('doctors.show', $doctor) }}" class="btn btn-sm">View</a></td>
                </tr>
            @empty
                <tr><td colspan="6">No doctors found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $doctors->links() }}</div>
</div>
@endsection