@extends('layouts.admin')

@section('title', 'Edit Dr. ' . ($doctor->user->name ?? 'Doctor'))

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.doctors.show', $doctor) }}" class="p-2 rounded-lg hover:bg-slate-100">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Edit Doctor</h2>
            <p class="text-sm text-slate-500">Update profile for Dr. {{ $doctor->user->name ?? 'N/A' }}</p>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Account Information --}}
        <div class="card">
            <h3 class="font-semibold text-slate-800 mb-4">Account Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $doctor->user->name) }}" required class="form-input">
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $doctor->user->email) }}" required class="form-input">
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $doctor->user->phone) }}" class="form-input">
                    @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-input">
                        <option value="1" {{ old('is_active', $doctor->is_active) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', $doctor->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Professional Information --}}
        <div class="card">
            <h3 class="font-semibold text-slate-800 mb-4">Professional Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Specialisation <span class="text-red-500">*</span></label>
                    <select name="specialisation_id" required class="form-input">
                        @foreach($specialisations as $spec)
                            <option value="{{ $spec->id }}" {{ old('specialisation_id', $doctor->specialisation_id) == $spec->id ? 'selected' : '' }}>{{ $spec->name }}</option>
                        @endforeach
                    </select>
                    @error('specialisation_id') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Registration No. <span class="text-red-500">*</span></label>
                    <input type="text" name="registration_no" value="{{ old('registration_no', $doctor->registration_no) }}" required class="form-input">
                    @error('registration_no') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Qualification</label>
                    <input type="text" name="qualification" value="{{ old('qualification', $doctor->qualification) }}" class="form-input">
                    @error('qualification') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Experience (Years)</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', $doctor->experience_years) }}" min="0" max="60" class="form-input">
                    @error('experience_years') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Consultation Fee (₹)</label>
                    <input type="number" name="consultation_fee" value="{{ old('consultation_fee', $doctor->consultation_fee) }}" min="0" step="0.01" class="form-input">
                    @error('consultation_fee') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" rows="3" class="form-input">{{ old('bio', $doctor->bio) }}</textarea>
                    @error('bio') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Update Doctor
            </button>
        </div>

    </form>

</div>
@endsection