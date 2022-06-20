<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpensePayment extends Model
{
	protected $fillable = ['expense_id','amount','description','paid_at'];

    public function expense()
    {
    	return $this->belongsTo('\App\Models\Expense');
    }
}
