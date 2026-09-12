<?php

namespace Modules\Appointments\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentRecord extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'appointment_id','doctor_id','patient_id','diagnosis',
        'treatment_done','prescription','follow_up_date','notes',
    ];

    public function appointment() { return $this->belongsTo(Appointment::class); }
    public function doctor() { return $this->belongsTo(\Modules\Doctors\Models\Doctor::class); }
}