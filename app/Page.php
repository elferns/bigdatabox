<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'name', 'title', 'slug', 'content', 'status', 'seo_keywords', 'seo_description'
    ];
}
