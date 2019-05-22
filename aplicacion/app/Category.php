<?php

namespace App;

use App\Notice;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function notices()
    {
    	return $this->hasMany(Notice::class);
    }
}
