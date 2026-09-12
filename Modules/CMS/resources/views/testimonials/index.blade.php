@extends('layouts.admin')
@section('title', 'Testimonials')
@section('content')
<div class="card">
    <h2>Add Testimonial</h2>
    <form method="POST" action="{{ route('cms.testimonials.store') }}">
        @csrf
        <label>Patient Name</label>
        <input name="patient_name" required>
        <label>Rating (1-5)</label>
        <input type="number" name="rating" min="1" max="5" value="5" required>
        <label>Review</label>
        <textarea name="review" required></textarea>
        <label style="display:flex; align-items:center; gap:.5rem;">
            <input type="checkbox" name="is_published" value="1" style="width:auto;"> Publish
        </label>
        <button class="btn" style="margin-top:1rem;" type="submit">Add</button>
    </form>
</div>
<div class="card">
    <h2>All Testimonials</h2>
    @forelse($testimonials as $t)
        <div style="border-bottom:1px solid #eee; padding:.5rem 0;">
            <strong>{{ $t->patient_name }}</strong> — {{ $t->rating }}★
            <p>{{ $t->review }}</p>
            <span class="badge">{{ $t->is_published ? 'Published' : 'Draft' }}</span>
            <form method="POST" action="{{ route('cms.testimonials.destroy', $t) }}" style="display:inline;">
                @csrf @method('DELETE')
                <button class="btn btn-sm" style="background:#dc2626;" type="submit">Delete</button>
            </form>
        </div>
    @empty
        <p style="color:#94a3b8;">No testimonials yet.</p>
    @endforelse
</div>
@endsection