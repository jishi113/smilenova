<?php

namespace Modules\Settings\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicSetting extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'key',
        'value',
        'group',
        'label',
        'type',
    ];
}