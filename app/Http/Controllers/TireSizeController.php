<?php

namespace App\Http\Controllers;

use App\Models\TireSize;
use App\Http\Requests\TireSizeRequest;


use Illuminate\Http\Request;
use Log;

class TireSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = TireSize::orderBy('id', 'desc')->paginate(10);
        return request()->json(200, $rows);
    }

    public function getAll()
    {
        $rows = TireSize::orderBy('name')->get();
        return request()->json(200, $rows);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TireSizeRequest $request)
    {
        $obj = TireSize::create($request->all());
        if($obj)
        {
            return $this->index();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TireSize  $tireSize
     * @return \Illuminate\Http\Response
     */
    public function show(TireSize $tireSize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TireSize  $tireSize
     * @return \Illuminate\Http\Response
     */
    public function edit(TireSize $tireSize)
    {
        return $tireSize;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TireSize  $tireSize
     * @return \Illuminate\Http\Response
     */
    public function update(TireSizeRequest $request, TireSize $tireSize)
    {
        $tireSize->update($request->all());
        
        if($tireSize)
        {
            return $this->index();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TireSize  $tireSize
     * @return \Illuminate\Http\Response
     */
    public function destroy(TireSize $tireSize)
    {
        if($tireSize->delete())
            return $this->index();
        else
            return response()->json(425, ['delete'=>'error deleting record']);
    }
}
