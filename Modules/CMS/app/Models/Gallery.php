<?php

namespace Modules\CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'gallery';
    public $timestamps = false;
    protected $fillable = ['title','image_path','category','sort_order','is_published'];
}