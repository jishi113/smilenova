@extends('layouts.admin')
@section('title', 'Edit Patient')
@section('content')
<div class="card">
    <h2>Edit {{ $patient->full_name }}</h2>
    <form method="POST" action="{{ route('patients.update', $patient) }}">
        @csrf @method('PUT')
        <div class="grid" style="grid-template-columns:1fr 1fr;">
            <div><label>First Name</label><input name="first_name" value="{{ old('first_name', $patient->first_name) }}" required></div>
            <div><label>Last Name</label><input name="last_name" value="{{ old('last_name', $patient->last_name) }}" required></div>
            <div><label>Phone</label><input name="phone" value="{{ old('phone', $patient->phone) }}" required></div>
            <div><label>Email</label><input name="email" type="email" value="{{ old('email', $patient->email) }}"></div>
            <div><label>Date of Birth</label><input name="date_of_birth" type="date" value="{{ old('date_of_birth', $patient->date_of_birth?->format('Y-m-d')) }}"></div>
            <div><label>Gender</label>
                <select name="gender">
                    <option value="">--</option>
                    <option value="male" @selected($patient->gender=='male')>Male</option>
                    <option value="female" @selected($patient->gender=='female')>Female</option>
                    <option value="other" @selected($patient->gender=='other')>Other</option>
                </select>
            </div>
            <div><label>Blood Group</label><input name="blood_group" value="{{ old('blood_group', $patient->blood_group) }}"></div>
            <div><label>Emergency Contact Name</label><input name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"></div>
            <div><label>Emergency Contact Phone</label><input name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}"></div>
        </div>
        <label>Address</label>
        <textarea name="address">{{ old('address', $patient->address) }}</textarea>
        <label>Allergies</label>
        <textarea name="allergies">{{ old('allergies', $patient->allergies) }}</textarea>
        <label>Notes</label>
        <textarea name="notes">{{ old('notes', $patient->notes) }}</textarea>
        <button class="btn" style="margin-top:1rem;" type="submit">Save Changes</button>
    </form>
</div>
@endsection