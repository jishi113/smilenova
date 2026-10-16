<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'appointment_id',
        'patient_id',
        'generated_by',
        'subtotal',
        'discount',
        'tax_rate',
        'tax_amount',
        'total',
        'status',
        'due_date',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'due_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(\Modules\Patients\Models\Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(\Modules\Appointments\Models\Appointment::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}