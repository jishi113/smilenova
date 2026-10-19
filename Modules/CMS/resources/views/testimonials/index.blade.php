@extends('layouts.admin')
@section('title', 'CMS — Testimonials')
@section('content')
<div class="space-y-6">
    <h2 class="text-xl font-semibold text-slate-800">Testimonials</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($testimonials as $t)
            <div class="card">
                <div class="flex justify-between items-start mb-2">
                    <p class="font-semibold">{{ $t->patient_name }}</p>
                    <span class="text-amber-500">★ {{ $t->rating }}</span>
                </div>
                <p class="text-sm text-slate-600">{{ $t->review }}</p>
                <span class="badge {{ $t->is_published ? 'badge-green' : 'badge-gray' }} mt-3 inline-block">{{ $t->is_published ? 'Published' : 'Draft' }}</span>
            </div>
        @empty
            <p class="col-span-3 text-center py-8 text-slate-400">No testimonials yet.</p>
        @endforelse
    </div>
</div>
@endsection