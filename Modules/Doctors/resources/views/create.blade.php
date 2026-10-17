@extends('layouts.admin')

@section('title', 'Add Doctor')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.doctors.index') }}" class="p-2 rounded-lg hover:bg-slate-100">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Add New Doctor</h2>
            <p class="text-sm text-slate-500">Create a doctor account and profile</p>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.doctors.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Account Information --}}
        <div class="card">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-8 h-8 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="font-semibold text-slate-800">Account Information</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="form-input" placeholder="Dr. John Doe">
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="doctor@smilenova.in">
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required class="form-input" placeholder="Minimum 8 characters">
                    @error('password') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="+91 98765 43210">
                    @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Professional Information --}}
        <div class="card">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="font-semibold text-slate-800">Professional Information</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Specialisation <span class="text-red-500">*</span></label>
                    <select name="specialisation_id" required class="form-input">
                        <option value="">Select specialisation</option>
                        @foreach($specialisations as $spec)
                            <option value="{{ $spec->id }}" {{ old('specialisation_id') == $spec->id ? 'selected' : '' }}>{{ $spec->name }}</option>
                        @endforeach
                    </select>
                    @error('specialisation_id') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Registration No. <span class="text-red-500">*</span></label>
                    <input type="text" name="registration_no" value="{{ old('registration_no') }}" required class="form-input" placeholder="MH-DEN-005">
                    @error('registration_no') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Qualification</label>
                    <input type="text" name="qualification" value="{{ old('qualification') }}" class="form-input" placeholder="BDS, MDS">
                    @error('qualification') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Experience (Years)</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', 0) }}" min="0" max="60" class="form-input">
                    @error('experience_years') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Consultation Fee (₹)</label>
                    <input type="number" name="consultation_fee" value="{{ old('consultation_fee', 0) }}" min="0" step="0.01" class="form-input">
                    @error('consultation_fee') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-input">
                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" rows="3" class="form-input" placeholder="Brief description of the doctor's expertise">{{ old('bio') }}</textarea>
                    @error('bio') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Save Doctor
            </button>
        </div>

    </form>

</div>
@endsection