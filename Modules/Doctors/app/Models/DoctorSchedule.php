<?php

namespace Modules\Doctors\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    public $timestamps = false;
    protected $fillable = ['doctor_id', 'day_of_week', 'start_time', 'end_time', 'slot_duration', 'max_patients', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function doctor() { return $this->belongsTo(Doctor::class); }
}