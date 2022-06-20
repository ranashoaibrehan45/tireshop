<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'description'];

    public function store($request)
    {
    	$this->name = $request->input('name');
    	$this->slug = str_slug($request->input('name'), '-');

    	if($request->has('slug') && $request->input('slug')!=='')
    	{
    		$this->slug = $request->input('slug');
    	}

    	$this->description = $request->input('description');
    	return $this->save();
    }
}
