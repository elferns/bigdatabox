<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'page_id', 'status',
    ];

    /**
     * Get the page that owns the navigation.
     */
    public function page()
    {
        $this->belongsTo('App\Page');
    }
}
