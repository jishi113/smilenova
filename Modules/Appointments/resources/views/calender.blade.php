@extends('layouts.admin')
@section('title', 'Calendar')
@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
        <a href="?month={{ \Carbon\Carbon::parse($month)->subMonth()->format('Y-m') }}" class="btn btn-sm">← Prev</a>
        <h2>{{ \Carbon\Carbon::parse($month)->format('F Y') }}</h2>
        <a href="?month={{ \Carbon\Carbon::parse($month)->addMonth()->format('Y-m') }}" class="btn btn-sm">Next →</a>
    </div>
    <div style="display:grid; grid-template-columns:repeat(7,1fr); gap:4px;">
        @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d)
            <div style="text-align:center; font-weight:bold; font-size:.8rem; padding:.5rem;">{{ $d }}</div>
        @endforeach
        @for($day = $startDate->copy(); $day->lte($endDate); $day->addDay())
            @php
                $dateKey = $day->toDateString();
                $dayAppts = $appointments[$dateKey] ?? collect();
                $inMonth = $day->format('Y-m') == $month;
            @endphp
            <div style="min-height:90px; padding:4px; border:1px solid #e2e8f0; background:{{ $day->isToday() ? '#eff6ff' : '#fff' }}; opacity:{{ $inMonth ? '1' : '0.4' }};">
                <div style="text-align:right; font-size:.75rem; font-weight:bold;">{{ $day->day }}</div>
                @foreach($dayAppts->take(3) as $appt)
                    <a href="{{ route('appointments.show', $appt) }}" style="display:block; font-size:.65rem; padding:2px 4px; margin-bottom:2px; border-radius:4px; background:{{ $appt->status=='completed' ? '#dcfce7' : '#dbeafe' }}; text-decoration:none; color:#1e293b; overflow:hidden; white-space:nowrap; text-overflow:ellipsis;">
                        {{ \Carbon\Carbon::parse($appt->start_time)->format('h:ia') }} {{ $appt->patient->first_name }}
                    </a>
                @endforeach
                @if($dayAppts->count() > 3)
                    <a href="{{ route('appointments.index', ['date'=>$dateKey]) }}" style="font-size:.65rem; color:#2563eb;">+{{ $dayAppts->count()-3 }} more</a>
                @endif
            </div>
        @endfor
    </div>
</div>
@endsection