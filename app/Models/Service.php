<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'category', 'description', 'price', 'duration', 'is_active'];
    public $timestamps = false;
}