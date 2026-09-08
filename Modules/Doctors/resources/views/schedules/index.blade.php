@extends('layouts.admin')
@section('title', 'Schedule — Dr. ' . $doctor->user->name)
@section('content')
<div class="card">
    <h2>Weekly Schedule — Dr. {{ $doctor->user->name }}</h2>
    <form method="POST" action="{{ route('doctors.schedules.save', $doctor) }}">
        @csrf
        <table>
            <thead><tr><th>Day</th><th>Active</th><th>Start</th><th>End</th><th>Slot (min)</th><th>Max Patients</th></tr></thead>
            <tbody>
                @foreach($dayNames as $index => $name)
                    @php $sch = $schedules[$index] ?? null; @endphp
                    <tr>
                        <td>{{ $name }}</td>
                        <td><input type="checkbox" name="schedules[{{ $index }}][is_active]" value="1" style="width:auto;" @checked($sch?->is_active)></td>
                        <td><input type="time" name="schedules[{{ $index }}][start_time]" value="{{ $sch->start_time ?? '09:00' }}"></td>
                        <td><input type="time" name="schedules[{{ $index }}][end_time]" value="{{ $sch->end_time ?? '17:00' }}"></td>
                        <td>
                            <select name="schedules[{{ $index }}][slot_duration]">
                                @foreach([15,20,30,45,60] as $d)
                                    <option value="{{ $d }}" @selected(($sch->slot_duration ?? 30)==$d)>{{ $d }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="schedules[{{ $index }}][max_patients]" value="{{ $sch->max_patients ?? 15 }}"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button class="btn" style="margin-top:1rem;" type="submit">Save Schedule</button>
    </form>
</div>
@endsection