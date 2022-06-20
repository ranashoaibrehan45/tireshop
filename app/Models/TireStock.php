<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TireStock extends Model
{
    public function company()
    {
    	return $this->belongsTo('App\Models\Company', 'company_id');
    }

    public function size()
    {
    	return $this->belongsTo('App\Models\TireSize','size_id');
    }
}
