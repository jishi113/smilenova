<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number','appointment_id','patient_id','generated_by',
        'subtotal','discount','tax_rate','tax_amount','total','status','due_date','notes',
    ];

    public static function generateNumber(): string
    {
        $year = now()->format('Y');
        $month = now()->format('m');
        $count = static::whereYear('created_at', $year)->whereMonth('created_at', $month)->count() + 1;
        return 'SNV-' . $year . $month . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function patient() { return $this->belongsTo(\Modules\Patients\Models\Patient::class); }
    public function appointment() { return $this->belongsTo(\Modules\Appointments\Models\Appointment::class); }
    public function items() { return $this->hasMany(InvoiceItem::class); }
    public function payments() { return $this->hasMany(Payment::class); }
}