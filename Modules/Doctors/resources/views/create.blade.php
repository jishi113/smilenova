@extends('layouts.admin')
@section('title', 'New Doctor')
@section('content')
<div class="card">
    <h2>Add New Doctor</h2>
    <form method="POST" action="{{ route('doctors.store') }}">
        @csrf
        <label>Full Name</label>
        <input name="name" value="{{ old('name') }}" required>
        <label>Email (login)</label>
        <input name="email" type="email" value="{{ old('email') }}" required>
        <label>Specialisation</label>
        <select name="specialisation_id" required>
            <option value="">-- Select --</option>
            @foreach($specialisations as $s)
                <option value="{{ $s->id }}">{{ $s->name }}</option>
            @endforeach
        </select>
        <label>Registration No.</label>
        <input name="registration_no" value="{{ old('registration_no') }}" required>
        <label>Qualification</label>
        <input name="qualification" value="{{ old('qualification') }}">
        <label>Experience (years)</label>
        <input name="experience_years" type="number" value="{{ old('experience_years', 0) }}">
        <label>Consultation Fee</label>
        <input name="consultation_fee" type="number" step="0.01" value="{{ old('consultation_fee', 0) }}">
        <label>Bio</label>
        <textarea name="bio">{{ old('bio') }}</textarea>
        @if($errors->any())
            <div class="success" style="background:#fee2e2; color:#991b1b; margin-top:1rem;">
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <p style="color:#64748b; font-size:.85rem;">Default login password: <strong>Smile@2026</strong></p>
        <button class="btn" type="submit">Create Doctor</button>
    </form>
</div>
@endsection