<?php

namespace Modules\Patients\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Patient extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'patient_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'blood_group',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'allergies',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
        'registered_at' => 'datetime',
    ];

    public static function generateCode(): string
    {
        $year = now()->year;
        $count = static::whereYear('registered_at', $year)->count() + 1;
        return 'PT-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? Carbon::parse($this->date_of_birth)->age : null;
    }
    public function appointments()
{
    return $this->hasMany(\Modules\Appointments\Models\Appointment::class);
}

public function treatments()
{
    return $this->hasMany(\Modules\Appointments\Models\TreatmentRecord::class);
}

public function invoices()
{
    return $this->hasMany(\Modules\Billing\Models\Invoice::class);
}
}