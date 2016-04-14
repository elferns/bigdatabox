<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Portfolio extends Model
{

	protected $dateFormat = 'Y.m.d';
    /**
     * Get the launch date.
     *
     * @param  string  $value
     * @return string
     */
    public function getLaunchDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    /**
     * Get the launch date for forms.
     *
     * @param  string  $value
     * @return string
     */
    public function formLaunchDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
}
