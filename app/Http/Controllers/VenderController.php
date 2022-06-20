<?php

namespace App\Http\Controllers;

use App\Models\Vender;
use Illuminate\Http\Request;
use App\Http\Requests\VenderRequest;

class VenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Vender::orderBy('id', 'desc')->paginate(10);
        return request()->json(200, $rows);
    }

    public function getAll()
    {
        $rows = Vender::orderBy('name')->get();
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
    public function store(VenderRequest $request)
    {
        $obj = Vender::create($request->all());
        if($obj)
        {
            return $this->index();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vender  $vender
     * @return \Illuminate\Http\Response
     */
    public function show(Vender $vender)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vender  $vender
     * @return \Illuminate\Http\Response
     */
    public function edit(Vender $vender)
    {
        return $vender;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vender  $vender
     * @return \Illuminate\Http\Response
     */
    public function update(VenderRequest $request, Vender $vender)
    {
        $vender->update($request->all());
        
        if($vender)
        {
            return $this->index();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vender  $vender
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vender $vender)
    {
        if($vender->delete())
            return $this->index();
        else
            return response()->json(425, ['delete'=>'error deleting record']);
    }
    
}// end of class
