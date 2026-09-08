@extends('layouts.admin')
@section('title', 'Edit Doctor')
@section('content')
<div class="card">
    <h2>Edit Dr. {{ $doctor->user->name }}</h2>
    <form method="POST" action="{{ route('doctors.update', $doctor) }}">
        @csrf @method('PUT')
        <label>Specialisation</label>
        <select name="specialisation_id" required>
            @foreach($specialisations as $s)
                <option value="{{ $s->id }}" @selected($doctor->specialisation_id == $s->id)>{{ $s->name }}</option>
            @endforeach
        </select>
        <label>Qualification</label>
        <input name="qualification" value="{{ old('qualification', $doctor->qualification) }}">
        <label>Experience (years)</label>
        <input name="experience_years" type="number" value="{{ old('experience_years', $doctor->experience_years) }}">
        <label>Consultation Fee</label>
        <input name="consultation_fee" type="number" step="0.01" value="{{ old('consultation_fee', $doctor->consultation_fee) }}">
        <label>Bio</label>
        <textarea name="bio">{{ old('bio', $doctor->bio) }}</textarea>
        <label style="display:flex; align-items:center; gap:.5rem;">
            <input type="checkbox" name="is_active" value="1" style="width:auto;" @checked($doctor->is_active)> Active
        </label>
        <button class="btn" style="margin-top:1rem;" type="submit">Save Changes</button>
    </form>
</div>
@endsection