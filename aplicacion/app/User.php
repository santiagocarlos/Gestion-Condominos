<?php

namespace App;

use App\Owner;
use App\Phone;
use App\Role;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'people_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function people()
    {
        return $this->belongsTo(People::class);
    }

    public function owner()
    {
        return $this->hasOne(Owner::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole(array $roles)
    {
        return $this->roles->pluck('name')->intersect($roles)->count();
    }

    public function isSuperAdmin()
    {
        return $this->hasRole(['super-admin']);
    }

    public function isAdmin()
    {
        return $this->hasRole(['admin']);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
