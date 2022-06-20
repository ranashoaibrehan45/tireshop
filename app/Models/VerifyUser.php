<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class VerifyUser extends Model
{
	protected $guarded = [];
	
	public function user()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}
}