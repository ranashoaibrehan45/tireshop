<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tire extends Model
{
    protected $fillable = [
    					'company_id',
    					'size_id',
    					'vender_id',
    					'quantity',
    					'purchase_price',
    					'purchase_date',
    					'short_note'
    				];

    public function company()
    {
    	return $this->belongsTo('App\Models\Company', 'company_id');
    }

    public function vender()
    {
    	return $this->belongsTo('App\Models\Vender', 'vender_id');
    }

    public function size()
    {
    	return $this->belongsTo('App\Models\TireSize','size_id');
    }
}
