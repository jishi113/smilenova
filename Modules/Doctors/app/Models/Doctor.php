<?php

namespace Modules\Doctors\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id', 'specialisation_id', 'registration_no', 'qualification',
        'experience_years', 'bio', 'consultation_fee', 'avatar', 'is_active',
    ];

    public function user() { return $this->belongsTo(\App\Models\User::class); }
    public function specialisation() { return $this->belongsTo(Specialisation::class); }
    public function schedules() { return $this->hasMany(DoctorSchedule::class); }
    public function appointments() { return $this->hasMany(\Modules\Appointments\Models\Appointment::class); }

    public function getFullNameAttribute(): string
    {
        return $this->user->name;
    }

    public function getAvailableSlotsFor(\Carbon\Carbon $date): array
    {
        $schedule = $this->schedules->firstWhere('day_of_week', $date->dayOfWeek);
        if (!$schedule || !$schedule->is_active) return [];

        $slots = [];
        $current = \Carbon\Carbon::parse($date->toDateString() . ' ' . $schedule->start_time);
        $end = \Carbon\Carbon::parse($date->toDateString() . ' ' . $schedule->end_time);

        $booked = \Modules\Appointments\Models\Appointment::where('doctor_id', $this->id)
            ->where('appointment_date', $date->toDateString())
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->pluck('start_time')
            ->map(fn($t) => substr($t, 0, 5))
            ->toArray();

        while ($current->lt($end)) {
            $timeStr = $current->format('H:i');
            $slots[] = [
                'time' => $timeStr,
                'label' => $current->format('h:i A'),
                'available' => !in_array($timeStr, $booked),
            ];
            $current->addMinutes($schedule->slot_duration);
        }

        return $slots;
    }
}