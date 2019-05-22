<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BanksCondominium extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_number', 'holder', 'dni', 'email', 'bank_id'
    ];


}
