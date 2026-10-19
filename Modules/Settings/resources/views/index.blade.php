@extends('layouts.admin')

@section('title', 'Clinic Settings')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-xl font-semibold text-slate-800">Clinic Settings</h2>
        <p class="text-sm text-slate-500">Manage your clinic information</p>
    </div>

    <form action="{{ route('admin.settings.save') }}" method="POST" class="space-y-6">
        @csrf

        <div class="card">
            <h3 class="font-semibold text-slate-800 mb-4">General Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Clinic Name</label>
                    <input type="text" name="clinic_name" value="{{ $settings['clinic_name'] ?? '' }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">Tagline</label>
                    <input type="text" name="clinic_tagline" value="{{ $settings['clinic_tagline'] ?? '' }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="clinic_email" value="{{ $settings['clinic_email'] ?? '' }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">Phone</label>
                    <input type="text" name="clinic_phone" value="{{ $settings['clinic_phone'] ?? '' }}" class="form-input">
                </div>
                <div class="md:col-span-2">
                    <label class="form-label">Address</label>
                    <textarea name="clinic_address" rows="2" class="form-input">{{ $settings['clinic_address'] ?? '' }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="form-label">Working Hours</label>
                    <input type="text" name="working_hours" value="{{ $settings['working_hours'] ?? '' }}" class="form-input">
                </div>
                <div class="md:col-span-2">
                    <label class="form-label">Footer Text</label>
                    <input type="text" name="footer_text" value="{{ $settings['footer_text'] ?? '' }}" class="form-input">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>
    </form>
</div>
@endsection