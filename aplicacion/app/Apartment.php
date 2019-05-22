<?php

namespace App;

use App\BillingNotice;
use App\Expense;
use App\Owner;
use App\Residential;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Apartment extends Model
{
  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
	     'tower_id', 'floor', 'apartment', 'intercom', 'parking', 'aliquot',
	  ];

  public function owner()
  {
  	return $this->belongsTo(Owner::class);
  }

  public function expenses()
  {
      return $this->hasMany(Expense::class);
  }

  public function billing_notices()
  {
      return $this->hasMany(BillingNotice::class);
  }

  public static function getInfoTableApartments()
  {
  	$apartments = Apartment::join('towers','apartments.tower_id','=','towers.id')
  													->select(
  														'towers.name',
  														'apartments.*'
  													)->with('billing_notices')->get();
  	return $apartments;
  }

  public static function getApartmentById($id)
  {
  	$id_decrypt = Crypt::decrypt($id);
  	$apartment = Apartment::join('towers','apartments.tower_id','=','towers.id')
  													->select(
  														'towers.name',
  														'apartments.*'
  													)->where('apartments.id','=',$id_decrypt)->first();
  	return $apartment;
  }

  public static function checkAvailabilityByFloor($tower, $floor)
  {
    $tower_decode = base64_decode($tower);
    $floor_decode = base64_decode($floor);

    $apartment = Apartment::where('tower_id','=',$tower_decode)->where('floor','=',$floor_decode)->count();
    $array_file = Residential::get();
    $floors = $array_file[1];
    $apartmentByTower = $array_file[3];
    $apartByFloor = $apartmentByTower / $floors;

    if ($apartment === null)
    {
      return $apartByFloor;
    }
    if ($apartment < $apartByFloor)
    {
      return $apartByFloor - $apartment;
    }
    else
    {
      return 'full';
    }
  }

  public static function getApartment($tower, $floor, $apartment)
  {
    $apto = Apartment::where('tower_id','=',$tower)
                      ->where('floor','=',$floor)
                      ->where('apartment','=',$apartment)->first();

    return $apto;
  }

  public static function getApartmentsToSelectMultiple()
  {
    $apartments = DB::table('apartments')
                      ->join('towers','apartments.tower_id','=','towers.id')
                      ->select('apartments.id',
                              'apartments.tower_id',
                              'apartments.floor',
                              'apartments.apartment',
                              'towers.name')
                      ->whereNOTIn('apartments.id',function($query){
                        $query->select('owners.apartment_id')->from('owners');
                      })->get();

    return $apartments;
  }

  public static function getApartmentsSelectMultiple()
  {
    $apartments = DB::table('apartments')
                      ->join('towers','apartments.tower_id','=','towers.id')
                      ->select('apartments.id',
                              'apartments.tower_id',
                              'apartments.floor',
                              'apartments.apartment',
                              'towers.name')
                      ->get();

    return $apartments;
  }




}
