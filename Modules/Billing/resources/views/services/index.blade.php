@extends('layouts.admin')

@section('title', 'Service Catalog')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Service Catalog</h2>
            <p class="text-sm text-slate-500">All available dental services</p>
        </div>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Service Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Duration</th>
                        <th class="text-right">Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td class="font-medium text-slate-800">{{ $service->name }}</td>
                            <td><span class="badge badge-purple">{{ $service->category ?? 'General' }}</span></td>
                            <td class="text-sm text-slate-600">{{ $service->description ?? '—' }}</td>
                            <td class="text-sm">{{ $service->duration }} min</td>
                            <td class="text-right font-semibold text-slate-800">₹{{ number_format($service->price, 2) }}</td>
                            <td>
                                @if($service->is_active)
                                    <span class="badge badge-green">Active</span>
                                @else
                                    <span class="badge badge-gray">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-slate-400">No services yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($services->hasPages())
            <div class="px-4 py-3 border-t border-slate-200">{{ $services->links() }}</div>
        @endif
    </div>
</div>
@endsection