@extends('layouts.admin')
@section('title', 'Add Staff User')
@section('content')
<div class="space-y-6 max-w-2xl">
    <h2 class="text-xl font-semibold text-slate-800">Add New Staff</h2>
    <form action="{{ route('admin.settings.users.store') }}" method="POST" class="card space-y-4">
        @csrf
        <div>
            <label class="form-label">Name *</label>
            <input type="text" name="name" required class="form-input">
        </div>
        <div>
            <label class="form-label">Email *</label>
            <input type="email" name="email" required class="form-input">
        </div>
        <div>
            <label class="form-label">Password *</label>
            <input type="password" name="password" required class="form-input">
        </div>
        <div>
            <label class="form-label">Role *</label>
            <select name="role" required class="form-input">
                <option value="">Select role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ ucwords(str_replace('_', ' ', $role->name)) }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex justify-end gap-2 pt-4">
            <a href="{{ route('admin.settings.users.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Create User</button>
        </div>
    </form>
</div>
@endsection