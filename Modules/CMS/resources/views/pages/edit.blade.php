@extends('layouts.admin')
@section('title', 'Edit Page')
@section('content')
<div class="card">
    <h2>Edit {{ $page->title }}</h2>
    <form method="POST" action="{{ route('cms.pages.update', $page) }}">
        @csrf @method('PUT')
        <label>Title</label>
        <input name="title" value="{{ $page->title }}" required>
        <label>Slug</label>
        <input name="slug" value="{{ $page->slug }}" required>
        <label>Template</label>
        <select name="template" required>
            <option value="default" @selected($page->template=='default')>Default</option>
            <option value="full_width" @selected($page->template=='full_width')>Full Width</option>
            <option value="sidebar" @selected($page->template=='sidebar')>Sidebar</option>
            <option value="landing" @selected($page->template=='landing')>Landing</option>
        </select>
        <label>Content</label>
        <textarea name="content" rows="10">{{ $page->content }}</textarea>
        <label>Meta Title</label>
        <input name="meta_title" value="{{ $page->meta_title }}">
        <label>Meta Description</label>
        <textarea name="meta_desc">{{ $page->meta_desc }}</textarea>
        <label style="display:flex; align-items:center; gap:.5rem;">
            <input type="checkbox" name="is_published" value="1" style="width:auto;" @checked($page->is_published)> Published
        </label>
        <button class="btn" style="margin-top:1rem;" type="submit">Save Changes</button>
    </form>
</div>
@endsection