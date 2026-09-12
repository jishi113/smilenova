<?php

namespace Modules\Settings\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicSetting extends Model
{
    public $timestamps = false;
    protected $table = 'clinic_settings';
    protected $fillable = ['key', 'value', 'group', 'label', 'type'];
}