<?php

namespace App;


use App\Admin;
use App\Owner;
use App\People;
use App\Phone;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class People extends Model
{
   protected $fillable = [
       'ci', 'name', 'last_name', 'birth',
    ];

    protected $table = 'peoples';

    //Relacion con User

    public function user()
    {
    	return $this->hasOne(User::class);
    }

    public function phones()
    {
    	return $this->hasMany(Phone::class);
    }

    public static function getInfo()
    {
        $info = People::with('user','phones')
                        ->where('peoples.id','=', Auth::user()->id)
                        ->first();
        return $info;
    }
}
