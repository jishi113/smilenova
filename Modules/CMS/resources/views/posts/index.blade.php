@extends('layouts.admin')
@section('title', 'CMS — Blog Posts')
@section('content')
<div class="space-y-6">
    <h2 class="text-xl font-semibold text-slate-800">Blog Posts</h2>
    <div class="card">
        <table class="table">
            <thead><tr><th>Title</th><th>Category</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->category ?? '—' }}</td>
                        <td><span class="badge {{ $post->is_published ? 'badge-green' : 'badge-gray' }}">{{ $post->is_published ? 'Published' : 'Draft' }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center py-8 text-slate-400">No posts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection