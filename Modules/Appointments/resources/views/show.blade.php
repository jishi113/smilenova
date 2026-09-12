@extends('layouts.admin')
@section('title', 'Appointment Details')
@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2>Appointment — {{ $appointment->appointment_date->format('d M Y') }} at {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}</h2>
        <span class="badge">{{ ucfirst($appointment->status) }}</span>
    </div>

    <p><strong>Patient:</strong> <a href="{{ route('patients.show', $appointment->patient) }}">{{ $appointment->patient->full_name }}</a></p>
    <p><strong>Doctor:</strong> Dr. {{ $appointment->doctor->user->name }}</p>
    <p><strong>Service:</strong> {{ $appointment->service->name ?? 'General Checkup' }}</p>
    <p><strong>Reason:</strong> {{ $appointment->reason ?? '—' }}</p>

    @can('appointments.edit')
        <div style="margin-top:1rem; display:flex; gap:.5rem;">
            @if($appointment->status == 'confirmed')
                <form method="POST" action="{{ route('appointments.status', $appointment) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="in_progress">
                    <button class="btn btn-sm" type="submit">Start</button>
                </form>
            @endif
            @if(!in_array($appointment->status, ['completed','cancelled','no_show']))
                <form method="POST" action="{{ route('appointments.status', $appointment) }}" onsubmit="return confirm('Cancel this appointment?')">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="cancelled">
                    <input type="hidden" name="cancellation_reason" value="Cancelled by staff">
                    <button class="btn btn-sm" style="background:#dc2626;" type="submit">Cancel</button>
                </form>
            @endif
        </div>
    @endcan

    @if($appointment->status == 'completed' && $appointment->invoice)
        <p style="margin-top:1rem;"><a href="{{ route('billing.invoices.show', $appointment->invoice) }}" class="btn btn-sm">View Invoice</a></p>
    @elseif($appointment->status == 'completed')
        @can('billing.create')
            <form method="POST" action="{{ route('billing.generate', $appointment) }}" style="margin-top:1rem;">
                @csrf
                <button class="btn btn-sm" type="submit">Generate Invoice</button>
            </form>
        @endcan
    @endif
</div>

@if($appointment->status == 'in_progress')
    @can('patients.edit_medical_records')
        <div class="card">
            <h3>Record Treatment</h3>
            <form method="POST" action="{{ route('appointments.treatment', $appointment) }}">
                @csrf
                <label>Diagnosis</label>
                <textarea name="diagnosis" required></textarea>
                <label>Treatment Done</label>
                <textarea name="treatment_done" required></textarea>
                <label>Prescription</label>
                <textarea name="prescription"></textarea>
                <label>Follow-up Date</label>
                <input type="date" name="follow_up_date">
                <label>Notes</label>
                <textarea name="notes"></textarea>
                <button class="btn" style="margin-top:1rem;" type="submit">Save Treatment & Complete</button>
            </form>
        </div>
    @endcan
@endif

@if($appointment->treatment)
    <div class="card">
        <h3>Treatment Record</h3>
        <p><strong>Diagnosis:</strong> {{ $appointment->treatment->diagnosis }}</p>
        <p><strong>Treatment Done:</strong> {{ $appointment->treatment->treatment_done }}</p>
        <p><strong>Prescription:</strong> {{ $appointment->treatment->prescription ?? '—' }}</p>
    </div>
@endif
@endsection