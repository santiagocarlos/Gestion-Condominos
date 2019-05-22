<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArrearsInterests extends Model
{
	use DatesTranslator;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'billing_notice_id', 'surcharge', 'start_date', 'end_date'
    ];
    public $timestamps = false;
}
