<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    public $timestamps = false;
    protected $fillable = ['invoice_id', 'service_id', 'description', 'quantity', 'unit_price', 'total'];

    public function invoice() { return $this->belongsTo(Invoice::class); }
    public function service() { return $this->belongsTo(\App\Models\Service::class); }
}