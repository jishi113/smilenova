<?php

namespace Modules\Appointments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'service_id',
        'booked_by',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'reason',
        'notes',
        'cancellation_reason',
        'reminder_sent',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'reminder_sent' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(\Modules\Patients\Models\Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(\Modules\Doctors\Models\Doctor::class);
    }

    public function service()
    {
        return $this->belongsTo(\Modules\Billing\Models\Service::class);
    }

    public function treatment()
    {
        return $this->hasOne(TreatmentRecord::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'confirmed' => 'badge-green',
            'in_progress' => 'badge-yellow',
            'completed' => 'badge-blue',
            'cancelled', 'no_show' => 'badge-red',
            default => 'badge-gray',
        };
    }
}