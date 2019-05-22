<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = [
      "number", "people_id"
    ];

    public function people()
    {
    	return $this->belongsTo(People::class);
    }
}
