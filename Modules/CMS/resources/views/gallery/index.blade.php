@extends('layouts.admin')
@section('title', 'Gallery')
@section('content')
<div class="card">
    <h2>Upload Images</h2>
    <form method="POST" action="{{ route('cms.gallery.store') }}" enctype="multipart/form-data">
        @csrf
        <label>Images</label>
        <input type="file" name="images[]" multiple required>
        <label>Category</label>
        <select name="category">
            <option value="clinic">Clinic</option>
            <option value="staff">Staff</option>
            <option value="procedures">Procedures</option>
        </select>
        <button class="btn" style="margin-top:1rem;" type="submit">Upload</button>
    </form>
</div>
<div class="card">
    <h2>Gallery ({{ $images->count() }} images)</h2>
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem;">
        @forelse($images as $img)
            <div>
                <img src="{{ Storage::url($img->image_path) }}" style="width:100%; border-radius:6px;">
                <form method="POST" action="{{ route('cms.gallery.destroy', $img) }}">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm" style="background:#dc2626; margin-top:.3rem;" type="submit">Delete</button>
                </form>
            </div>
        @empty
            <p style="color:#94a3b8;">No images yet.</p>
        @endforelse
    </div>
</div>
@endsection