@extends('layouts.admin')
@section('title', 'New Post')
@section('content')
<div class="card">
    <h2>New Blog Post</h2>
    <form method="POST" action="{{ route('cms.posts.store') }}" enctype="multipart/form-data">
        @csrf
        <label>Title</label>
        <input name="title" required>
        <label>Excerpt</label>
        <textarea name="excerpt"></textarea>
        <label>Content</label>
        <textarea name="content" rows="10" required></textarea>
        <label>Category</label>
        <input name="category">
        <label>Tags (comma separated)</label>
        <input name="tags">
        <label>Featured Image</label>
        <input type="file" name="featured_image">
        <label style="display:flex; align-items:center; gap:.5rem;">
            <input type="checkbox" name="is_published" value="1" style="width:auto;"> Publish immediately
        </label>
        <button class="btn" style="margin-top:1rem;" type="submit">Save Post</button>
    </form>
</div>
@endsection