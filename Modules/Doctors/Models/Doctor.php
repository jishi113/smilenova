<?php

namespace Modules\Doctors\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'specialisation_id',
        'registration_no',
        'qualification',
        'experience_years',
        'bio',
        'consultation_fee',
        'avatar',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'consultation_fee' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function specialisation()
    {
        return $this->belongsTo(Specialisation::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->user->name ?? 'N/A';
    }
}