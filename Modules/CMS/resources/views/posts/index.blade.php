@extends('layouts.admin')
@section('title', 'Blog Posts')
@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
        <h2>Blog Posts</h2>
        <a href="{{ route('cms.posts.create') }}" class="btn">+ New Post</a>
    </div>
    <table>
        <thead><tr><th>Title</th><th>Category</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->category ?? '—' }}</td>
                    <td><span class="badge">{{ $post->is_published ? 'Published' : 'Draft' }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('cms.posts.toggle', $post) }}" style="display:inline;">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm" type="submit">{{ $post->is_published ? 'Unpublish' : 'Publish' }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No posts yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection