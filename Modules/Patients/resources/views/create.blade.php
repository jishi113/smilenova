@extends('layouts.admin')
@section('title', 'New Patient')
@section('content')
<div class="card">
    <h2>Register New Patient</h2>
    <form method="POST" action="{{ route('patients.store') }}">
        @csrf
        <div class="grid" style="grid-template-columns:1fr 1fr;">
            <div><label>First Name</label><input name="first_name" value="{{ old('first_name') }}" required></div>
            <div><label>Last Name</label><input name="last_name" value="{{ old('last_name') }}" required></div>
            <div><label>Phone</label><input name="phone" value="{{ old('phone') }}" required></div>
            <div><label>Email</label><input name="email" type="email" value="{{ old('email') }}"></div>
            <div><label>Date of Birth</label><input name="date_of_birth" type="date" value="{{ old('date_of_birth') }}"></div>
            <div><label>Gender</label>
                <select name="gender">
                    <option value="">--</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div><label>Blood Group</label><input name="blood_group" value="{{ old('blood_group') }}"></div>
            <div><label>Emergency Contact Name</label><input name="emergency_contact_name" value="{{ old('emergency_contact_name') }}"></div>
            <div><label>Emergency Contact Phone</label><input name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}"></div>
        </div>
        <label>Address</label>
        <textarea name="address">{{ old('address') }}</textarea>
        <label>Allergies</label>
        <textarea name="allergies">{{ old('allergies') }}</textarea>
        <label>Notes</label>
        <textarea name="notes">{{ old('notes') }}</textarea>
        @if($errors->any())
            <div class="success" style="background:#fee2e2; color:#991b1b; margin-top:1rem;">
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <button class="btn" style="margin-top:1rem;" type="submit">Register Patient</button>
    </form>
</div>
@endsection