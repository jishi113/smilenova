<?php

namespace Modules\CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public $timestamps = false;

    protected $table = 'gallery';

    protected $fillable = [
        'title',
        'image_path',
        'category',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}