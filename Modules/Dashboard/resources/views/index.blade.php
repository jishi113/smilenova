@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Welcome banner --}}
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-xl p-6 text-white">
        <h2 class="text-2xl font-bold mb-1">Welcome back, {{ $user->name }}! 👋</h2>
        <p class="text-primary-100 text-sm">Here's what's happening at SmileNova today.</p>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="kpi-card">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase">Today's Appointments</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['today_appointments'] }}</p>
                <p class="text-xs text-emerald-600 mt-1">{{ $stats['today_completed'] }} completed</p>
            </div>
            <div class="kpi-icon bg-primary-100 text-primary-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>

        <div class="kpi-card">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase">Total Patients</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['total_patients'] }}</p>
                <p class="text-xs text-emerald-600 mt-1">{{ $stats['new_patients_month'] }} this month</p>
            </div>
            <div class="kpi-icon bg-emerald-100 text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>

        <div class="kpi-card">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase">Revenue Today</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">₹{{ number_format($stats['revenue_today'], 0) }}</p>
                <p class="text-xs text-slate-500 mt-1">Month: ₹{{ number_format($stats['revenue_month'], 0) }}</p>
            </div>
            <div class="kpi-icon bg-amber-100 text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="kpi-card">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase">Outstanding</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">₹{{ number_format($stats['outstanding'], 0) }}</p>
                <p class="text-xs text-slate-500 mt-1">Unpaid invoices</p>
            </div>
            <div class="kpi-icon bg-red-100 text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="card">
        <h3 class="font-semibold text-slate-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary justify-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Book Appointment
            </a>
            <a href="{{ route('admin.patients.create') }}" class="btn btn-secondary justify-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Add Patient
            </a>
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary justify-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                View Calendar
            </a>
            <a href="{{ route('admin.billing.reports.revenue') }}" class="btn btn-secondary justify-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Reports
            </a>
        </div>
    </div>

</div>
@endsection