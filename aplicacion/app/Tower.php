<?php

namespace App;

use App\Admin;
use App\Apartment;
use App\Expense;
use App\Residential;
use App\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Tower extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name', 'admin_id'
    ];

	public function admin()
    {
    	return $this->belongsTo(Admin::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class)->withTimestamps();
    }

    public function apartments()
    {
        return $this->hasMany(Apartment::class);
    }

    public static function getTowers_Admin()
    {
        $towers = Tower::with('apartments')->get();

        /*$towers = Tower::join('admins','towers.admin_id','=','admins.id')
                        ->join('users','admins.user_id','=','users.id')
                        ->join('peoples','users.id','=','peoples.id')
                        ->select(
                            'towers.id as tower_id',
                            'towers.name as tower_name',
                            'towers.admin_id as admin_id',
                            'peoples.name as name',
                            'peoples.last_name as last_name')->with('apartments')->get();*/
        return $towers;
    }

    public static function getTowerById($id)
    {
        $id_decrypt = Crypt::decrypt($id);
        $tower = Tower::join('admins','towers.admin_id','=','admins.id')
                ->join('users','admins.user_id','=','users.id')
                ->join('peoples','users.id','=','peoples.id')
                ->select(
                    'towers.id as tower_id',
                    'towers.name as tower_name',
                    'towers.admin_id as admin_id',
                    'peoples.name as name',
                    'peoples.last_name as last_name')
                ->where('towers.id','=',$id_decrypt)->first();

        return $tower;
    }

    public static function getNameById($id)
    {
        $name = Tower::select('towers.id','towers.name')->where('towers.id','=',$id)->first();
        return $name;
    }
}
