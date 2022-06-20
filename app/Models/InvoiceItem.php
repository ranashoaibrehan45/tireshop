<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    public $timestamps = false;

    public function invoice()
    {
    	return $this->belongsTo('App\Models\Invoice');
    }
}
