<?php

namespace Modules\Doctors\Models;

use Illuminate\Database\Eloquent\Model;

class Specialisation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'description', 'icon'];

    public function doctors() { return $this->hasMany(Doctor::class); }
}