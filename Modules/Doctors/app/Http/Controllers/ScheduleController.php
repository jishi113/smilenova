<?php

namespace Modules\Doctors\Http\Controllers;

use Modules\Doctors\Models\Doctor;
use Modules\Doctors\Models\DoctorSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function index(Doctor $doctor)
    {
        $schedules = $doctor->schedules->keyBy('day_of_week');
        $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return view('doctors::schedules.index', compact('doctor', 'schedules', 'dayNames'));
    }

    public function bulkSave(Request $request, Doctor $doctor)
    {
        $request->validate([
            'schedules' => ['required', 'array'],
        ]);

        foreach ($request->schedules as $day => $data) {
            $isActive = isset($data['is_active']) && $data['is_active'] == '1';
            DoctorSchedule::updateOrCreate(
                ['doctor_id' => $doctor->id, 'day_of_week' => $day],
                [
                    'is_active' => $isActive,
                    'start_time' => $data['start_time'] ?? '09:00',
                    'end_time' => $data['end_time'] ?? '17:00',
                    'slot_duration' => $data['slot_duration'] ?? 30,
                    'max_patients' => $data['max_patients'] ?? 15,
                ]
            );
        }

        return back()->with('success', "Schedule saved for Dr. {$doctor->full_name}.");
    }
}