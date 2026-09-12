@extends('layouts.admin')
@section('title', 'New Page')
@section('content')
<div class="card">
    <h2>New Page</h2>
    <form method="POST" action="{{ route('cms.pages.store') }}">
        @csrf
        <label>Title</label>
        <input name="title" required>
        <label>Slug (optional — auto-generated from title)</label>
        <input name="slug">
        <label>Template</label>
        <select name="template" required>
            <option value="default">Default</option>
            <option value="full_width">Full Width</option>
            <option value="sidebar">Sidebar</option>
            <option value="landing">Landing</option>
        </select>
        <label>Content</label>
        <textarea name="content" rows="10"></textarea>
        <label>Meta Title</label>
        <input name="meta_title">
        <label>Meta Description</label>
        <textarea name="meta_desc"></textarea>
        <label style="display:flex; align-items:center; gap:.5rem;">
            <input type="checkbox" name="is_published" value="1" style="width:auto;"> Publish immediately
        </label>
        <button class="btn" style="margin-top:1rem;" type="submit">Create Page</button>
    </form>
</div>
@endsection