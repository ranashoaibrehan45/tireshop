<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['discount','short_note'];

    public function items()
    {
    	return $this->hasMany('App\Models\InvoiceItem');
    }
}
