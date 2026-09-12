@extends('layouts.admin')
@section('title', 'Clinic Settings')
@section('content')
<div class="card">
    <h2>Clinic Settings</h2>
    <form method="POST" action="{{ route('settings.save') }}" enctype="multipart/form-data">
        @csrf
        <label>Clinic Name</label>
        <input name="clinic_name" value="{{ $settings['clinic_name'] ?? '' }}" required>
        <label>Email</label>
        <input name="clinic_email" type="email" value="{{ $settings['clinic_email'] ?? '' }}" required>
        <label>Phone</label>
        <input name="clinic_phone" value="{{ $settings['clinic_phone'] ?? '' }}" required>
        <label>Address</label>
        <textarea name="clinic_address">{{ $settings['clinic_address'] ?? '' }}</textarea>
        <label>Logo</label>
        @if(!empty($settings['clinic_logo']))
            <img src="{{ Storage::url($settings['clinic_logo']) }}" style="height:60px; display:block; margin-bottom:.5rem;">
        @endif
        <input type="file" name="clinic_logo">
        <label>Tagline</label>
        <input name="clinic_tagline" value="{{ $settings['clinic_tagline'] ?? '' }}">
        <label>Working Hours</label>
        <input name="working_hours" value="{{ $settings['working_hours'] ?? '' }}">
        <label>Footer Text</label>
        <textarea name="footer_text">{{ $settings['footer_text'] ?? '' }}</textarea>
        <button class="btn" style="margin-top:1rem;" type="submit">Save Settings</button>
    </form>
</div>
@endsection