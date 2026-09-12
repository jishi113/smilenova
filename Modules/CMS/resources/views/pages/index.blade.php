@extends('layouts.admin')
@section('title', 'CMS Pages')
@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
        <h2>Pages</h2>
        <a href="{{ route('cms.pages.create') }}" class="btn">+ New Page</a>
    </div>
    <table>
        <thead><tr><th>Title</th><th>Slug</th><th>Published</th><th></th></tr></thead>
        <tbody>
            @forelse($pages as $page)
                <tr>
                    <td>{{ $page->title }}</td>
                    <td>/{{ $page->slug }}</td>
                    <td><span class="badge">{{ $page->is_published ? 'Published' : 'Draft' }}</span></td>
                    <td>
                        <a href="{{ route('cms.pages.edit', $page) }}" class="btn btn-sm">Edit</a>
                        <form method="POST" action="{{ route('cms.pages.destroy', $page) }}" style="display:inline;" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm" style="background:#dc2626;" type="submit">Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No pages yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection