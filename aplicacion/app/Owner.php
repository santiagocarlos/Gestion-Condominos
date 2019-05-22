<?php

namespace App;

use App\Apartment;
use App\Owner;
use App\People;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Owner extends Model
{
    protected $fillable = [
       'user_id', 'apartment_id', 'status'
    ];

    public static function getListOwners()
    {

        $owners = DB::select('SELECT users.id, users.email, peoples.name, peoples.last_name, GROUP_CONCAT("<li> ", towers.name, " - ", apartments.floor, " - ", apartments.apartment SEPARATOR "<br></li> ") as apartments_owner
                        FROM owners
                        JOIN apartments ON owners.apartment_id = apartments.id
                        JOIN users ON owners.user_id = users.id
                        JOIN peoples ON users.people_id = peoples.id
                        JOIN towers ON apartments.tower_id = towers.id
                        group by users.id');
        return $owners;
    }

    public static function insertOwner($data)
    {
        //dd($data);
        DB::transaction(function () use ($data)  {
             $people = People::create([
                    "ci" => $data['ci'],
                    "name" => $data['name'],
                    "last_name" => $data['last_name'],
                    "birth" => Carbon::parse($data['birth'])->format('Y-m-d'),
                ]);

                $user = User::create([
                    "email" => $data['email'],
                    "password" => bcrypt($data['password']),
                    "people_id" => $people->id,
                ]);
                $user->roles()->attach($data['role']);
                $people->phones()->create([
                    'number' => $data['phone'],
                ]);

                for ($i=0; $i < count($data['apartments']) ; $i++)
                {
                    $apartment = Apartment::where('id',$data['apartments'][$i])->first();
                    $owner = Owner::create([
                        "user_id" => $user->id,
                        "apartment_id" => $apartment->id,
                        'status' => false,
                    ]);
                }
        });
    }

    public static function findOwner($id)
    {
        $owner = DB::select('SELECT users.id, users.email, peoples.ci, peoples.name, peoples.last_name, DATE_FORMAT(peoples.birth, "%m-%d-%Y") as birth, phones.number,
                        GROUP_CONCAT(towers.name, " - ", apartments.floor, " - ", apartments.apartment SEPARATOR ", ") as apartments_owner
                        FROM owners
                        JOIN apartments ON owners.apartment_id = apartments.id
                        JOIN users ON owners.user_id = users.id
                        JOIN peoples ON users.people_id = peoples.id
                        JOIN phones ON peoples.id = phones.people_id
                        JOIN towers ON apartments.tower_id = towers.id
                        WHERE owners.user_id ='.$id);

        return $owner[0];
    }

    public static function getIdApartmentsOwners($id)
    {
        $owner = DB::select('SELECT GROUP_CONCAT(apartments.id SEPARATOR ",") as apartments_owner
                        FROM owners
                        JOIN apartments ON owners.apartment_id = apartments.id
                        JOIN users ON owners.user_id = users.id
                        JOIN peoples ON users.people_id = peoples.id
                        JOIN phones ON peoples.id = phones.people_id
                        JOIN towers ON apartments.tower_id = towers.id
                        WHERE owners.user_id ='.$id);

        return $owner;
    }

    public static function getApartmentsOwners($id)
    {
        $apartments = Owner::where('user_id',$id)->get()->toArray();
        return $apartments;
    }

    public static function updateApartments($id, $array)
    {
        $apartments_owner = Owner::where('user_id', $id)->delete();

        for ($i=0; $i < count($array) ; $i++)
        {
            $apartment = Owner::create([
                'user_id' => $id,
                'apartment_id' => $array[$i],
            ]);
        }
    }
}
