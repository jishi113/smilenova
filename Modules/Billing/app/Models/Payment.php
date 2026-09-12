<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $timestamps = false;
    protected $fillable = ['invoice_id', 'amount', 'payment_method', 'reference_no', 'received_by', 'notes'];

    public function invoice() { return $this->belongsTo(Invoice::class); }
}