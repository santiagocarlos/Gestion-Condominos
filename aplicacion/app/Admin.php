<?php

namespace App;

use App\Admin;
use App\Apartment;
use App\Owner;
use App\People;
use App\Tower;
use App\Traits\Excludable;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    use Notifiable;
    protected $fillable = [
       'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function towers()
    {
    	return $this->hasMany(Tower::class);
    }

    public static function getAdminOwner($id)
    {
        try {
            $admin = People::join('phones','phones.people_id','=','peoples.id')
                        ->join('users','users.people_id','=','peoples.id')
                        ->join('owners','owners.user_id','=','users.id')
                        ->where('peoples.id','=',$id)
                        ->select(
                            'peoples.id as peopleId',
                            'ci',
                            'peoples.name',
                            'peoples.last_name',
                            DB::raw("(DATE_FORMAT(peoples.birth, '%d-%m-%Y')) as birth_formated"),
                            'users.email',
                            'phones.number'
                        )
                        ->first();
            return $admin;
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return false;
        }
    }

    public static function getAdmin($id)
    {
        try {
            $admin = People::join('phones','phones.people_id','=','peoples.id')
                        ->join('users','users.people_id','=','peoples.id')
                        ->where('peoples.id','=',$id)
                        ->select(
                            'peoples.id',
                            'ci',
                            'peoples.name',
                            'peoples.last_name',
                            DB::raw("(DATE_FORMAT(peoples.birth, '%d-%m-%Y')) as birth_formated"),
                            'users.email',
                            'phones.number'
                        )
                        ->first();
            return $admin;
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return false;
        }
    }

    public static function insertAdminExtern($request)
    {
        DB::transaction(function () use ($request)  {
                $people = People::create([
                    "ci" => $request['ci'],
                    "name" => $request['name'],
                    "last_name" => $request['last_name'],
                    "birth" => Carbon::parse($request->input('birth'))->format('Y-m-d'),
                ]);

                $user = User::create([
                    "email" => $request['email'],
                    "password" => bcrypt($request['password']),
                    "people_id" => $people->id,
                ]);

                $user->roles()->attach($request['role']);
                $people->phones()->create([
                    'number' => $request['phone'],
                ]);

                $admin = Admin::create([
                    'user_id' => $people->id,
                ]);
            });
    }

    public static function insertAdminIntern($request)
    {
        DB::transaction(function () use ($request)  {
                $people = People::create([
                    "ci" => $request['ci'],
                    "name" => $request['name'],
                    "last_name" => $request['last_name'],
                    "birth" => Carbon::parse($request->input('birth'))->format('Y-m-d'),
                ]);

                $user = User::create([
                    "email" => $request['email'],
                    "password" => bcrypt($request['password']),
                    "people_id" => $people->id,
                ]);

                $user->roles()->attach($request['role']);
                $people->phones()->create([
                    'number' => $request['phone'],
                ]);

                $admin = Admin::create([
                    'user_id' => $people->id,
                ]);

                for ($i=0; $i < count($request['apartments']) ; $i++)
                {
                    $apartment = Apartment::where('id',$request['apartments'][$i])->first();
                    $owner = Owner::create([
                        "user_id" => $user->id,
                        "apartment_id" => $apartment->id,
                        'status' => false,
                    ]);
                }
            });
    }

    public static function deleteAdmin($id)
    {
        DB::transaction(function () use ($id)
        {
            $admin = Admin::where('user_id','=',$id)->delete();

            $user = User::findOrFail($id);
            $user->roles()->detach(1);
            $user->roles()->detach(2);
            $user->roles()->detach(3);
            $user->delete();

            $people = People::findOrFail($id);
            $people->phones()->delete();
            $people->delete();
        });
    }

}
