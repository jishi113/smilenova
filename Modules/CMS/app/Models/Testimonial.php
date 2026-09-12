<?php

namespace Modules\CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    public $timestamps = false;
    protected $fillable = ['patient_name','rating','review','avatar','is_published','sort_order'];
}