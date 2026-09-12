@extends('layouts.admin')
@section('title', 'Book Appointment')
@section('content')
<div class="card">
    <h2>Book Appointment</h2>
    <form method="POST" action="{{ route('appointments.store') }}" id="bookingForm">
        @csrf
        <label>Patient</label>
        <select name="patient_id" required>
            <option value="">-- Select Patient --</option>
            @foreach($patients as $p)
                <option value="{{ $p->id }}">{{ $p->full_name }} ({{ $p->patient_code }})</option>
            @endforeach
        </select>
        <label>Doctor</label>
        <select name="doctor_id" id="doctorSelect" required>
            <option value="">-- Select Doctor --</option>
            @foreach($doctors as $d)
                <option value="{{ $d->id }}">Dr. {{ $d->user->name }} — {{ $d->specialisation->name ?? '' }}</option>
            @endforeach
        </select>
        <label>Service (optional)</label>
        <select name="service_id">
            <option value="">-- General --</option>
            @foreach($services as $s)
                <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->duration }}min — ₹{{ $s->price }})</option>
            @endforeach
        </select>
        <label>Date</label>
        <input type="date" name="appointment_date" id="dateInput" min="{{ date('Y-m-d') }}" required>
        <button type="button" id="loadSlotsBtn" class="btn btn-sm" style="margin-top:.5rem;">Load Available Slots</button>

        <div id="slotsContainer" style="margin-top:1rem; display:flex; flex-wrap:wrap; gap:.5rem;"></div>
        <input type="hidden" name="start_time" id="startTimeInput">

        <label>Reason</label>
        <textarea name="reason"></textarea>

        @if($errors->any())
            <div class="success" style="background:#fee2e2; color:#991b1b; margin-top:1rem;">
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <button class="btn" style="margin-top:1rem;" type="submit" id="submitBtn" disabled>Book Appointment</button>
    </form>
</div>

<script>
document.getElementById('loadSlotsBtn').addEventListener('click', async function() {
    const doctorId = document.getElementById('doctorSelect').value;
    const date = document.getElementById('dateInput').value;
    if (!doctorId || !date) { alert('Select doctor and date first'); return; }

    const url = `{{ route('appointments.slots') }}?doctor_id=${doctorId}&date=${date}`;
    const res = await fetch(url);
    const data = await res.json();

    const container = document.getElementById('slotsContainer');
    container.innerHTML = '';
    if (!data.slots.length) {
        container.innerHTML = '<p style="color:#94a3b8;">No slots available — doctor may not work this day.</p>';
        return;
    }
    data.slots.forEach(slot => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = slot.label;
        btn.disabled = !slot.available;
        btn.style.padding = '.4rem .8rem';
        btn.style.borderRadius = '6px';
        btn.style.border = '1px solid #ccc';
        btn.style.background = slot.available ? '#fff' : '#f1f5f9';
        btn.style.color = slot.available ? '#1e293b' : '#94a3b8';
        btn.style.cursor = slot.available ? 'pointer' : 'not-allowed';
        btn.onclick = function() {
            document.getElementById('startTimeInput').value = slot.time;
            document.getElementById('submitBtn').disabled = false;
            document.querySelectorAll('#slotsContainer button').forEach(b => b.style.background = b.disabled ? '#f1f5f9' : '#fff');
            btn.style.background = '#2563eb';
            btn.style.color = '#fff';
        };
        container.appendChild(btn);
    });
});
</script>
@endsection