@extends('layouts.admin')
@section('title', 'Patients')
@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
        <h2>Patients</h2>
        @can('patients.create')
            <a href="{{ route('patients.create') }}" class="btn">+ New Patient</a>
        @endcan
    </div>

    <form method="GET" style="display:flex; gap:.5rem; margin-bottom:1rem;">
        <input type="text" name="search" placeholder="Search name, phone, code..." value="{{ request('search') }}">
        <select name="gender">
            <option value="">All Genders</option>
            <option value="male" @selected(request('gender')=='male')>Male</option>
            <option value="female" @selected(request('gender')=='female')>Female</option>
            <option value="other" @selected(request('gender')=='other')>Other</option>
        </select>
        <button class="btn btn-sm" type="submit">Filter</button>
    </form>

    <table>
        <thead>
            <tr><th>Code</th><th>Name</th><th>Phone</th><th>Gender</th><th>Age</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($patients as $patient)
                <tr>
                    <td>{{ $patient->patient_code }}</td>
                    <td><a href="{{ route('patients.show', $patient) }}">{{ $patient->full_name }}</a></td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ ucfirst($patient->gender ?? '—') }}</td>
                    <td>{{ $patient->age ?? '—' }}</td>
                    <td><a href="{{ route('patients.show', $patient) }}" class="btn btn-sm">View</a></td>
                </tr>
            @empty
                <tr><td colspan="6">No patients found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:1rem;">{{ $patients->links() }}</div>
</div>
@endsection