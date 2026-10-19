@extends('layouts.admin')
@section('title', 'CMS — Pages')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-slate-800">Pages</h2>
    </div>
    <div class="card">
        <table class="table">
            <thead><tr><th>Title</th><th>Slug</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td><code>/{{ $page->slug }}</code></td>
                        <td><span class="badge {{ $page->is_published ? 'badge-green' : 'badge-gray' }}">{{ $page->is_published ? 'Published' : 'Draft' }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center py-8 text-slate-400">No pages yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection