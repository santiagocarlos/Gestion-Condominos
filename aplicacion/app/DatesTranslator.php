<?php

namespace App;

use Illuminate\Support\Carbon;
use Jenssegers\Date\Date;

trait DatesTranslator
{
	public function getCreatedAtAttribute($date)
  {
    return new Date($date);
  }

  public function getUpdatedAtAttribute($date)
  {
    return new Date($date);
  }

	public function getDateAttribute($date)
  {
    return new Date($date);
  }

  public function getDatePayAttribute($date)
  {
    return new Date($date);
  }

  /*public function getDateConfirmAttribute($date)
  {
    return Carbon::parse($date)->format($this->newDateFormat);
    //return new Date($date);
  }*/
}