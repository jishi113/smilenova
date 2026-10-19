<?php

namespace Modules\CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_desc',
        'is_published',
        'template',
        'sort_order',
        'created_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}