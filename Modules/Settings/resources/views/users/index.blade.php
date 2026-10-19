@extends('layouts.admin')
@section('title', 'Staff Users')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between">
        <h2 class="text-xl font-semibold text-slate-800">Staff Users</h2>
        <a href="{{ route('admin.settings.users.create') }}" class="btn btn-primary">+ Add Staff</a>
    </div>
    <div class="card overflow-hidden">
        <table class="table">
            <thead><tr><th>Name</th><th>Email</th><th>Role</th><th class="text-right">Actions</th></tr></thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->getRoleNames() as $role)
                                <span class="badge badge-purple">{{ $role }}</span>
                            @endforeach
                        </td>
                        <td class="text-right">
                            <form action="{{ route('admin.settings.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete user?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection