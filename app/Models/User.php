<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	public function verifyUser()
    {
        return $this->hasOne('App\Models\VerifyUser');
    }

    public function taskerProfile()
    {
        return $this->hasOne('App\Models\TaskerProfile');
    }
    
    public function taskerSkill()
    {
        return $this->hasMany('App\Models\TaskerSkill');
    }
    
    public function taskerVehicle()
    {
        return $this->hasMany('App\Models\TaskerVehicle');
    }
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }
}
