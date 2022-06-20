<?php

namespace App\Http\Controllers;

use App\Models\Tire;
use App\Models\TireStock;
use Illuminate\Http\Request;
use App\Http\Requests\TireRequest;

use DB;

class TireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Tire::orderBy('id', 'desc')
                    ->with('company')
                    ->with('vender')
                    ->with('size')
                    ->paginate(10);
                    
        return request()->json(200, $rows);
    }

    public function getAll()
    {
        $rows = Tire::orderBy('id', 'desc')
                    ->with('company')
                    ->with('size')
                    ->get();
                    
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
    public function store(TireRequest $request)
    {
        try
        {
            DB::beginTransaction();

            $obj = Tire::create($request->all());
            if($obj)
            {
                $tireStock = TireStock::where('company_id', $request->input('company_id'))
                                      ->where('size_id', $request->input('size_id'))
                                      ->first();

                if(!$tireStock)
                {
                    $tireStock = new TireStock();
                    $tireStock->company_id = $request->input('company_id');
                    $tireStock->size_id = $request->input('size_id');
                    $tireStock->quantity = $request->input('quantity');
                }
                else
                {
                    $tireStock->quantity += $request->input('quantity');
                }

                $tireStock->price = $request->input('sale_price');

                if($tireStock->save())
                {
                    DB::commit();
                    return $this->index();
                }
            }
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tire  $tire
     * @return \Illuminate\Http\Response
     */
    public function show(Tire $tire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tire  $tire
     * @return \Illuminate\Http\Response
     */
    public function edit($tire)
    {
        return Tire::where('id', $tire)
                    ->with('company')
                    ->with('vender')
                    ->with('size')
                    ->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tire  $tire
     * @return \Illuminate\Http\Response
     */
    public function update(TireRequest $request, Tire $tire)
    {
        try{
            DB::beginTransaction();
            $tireStock = TireStock::where('company_id', $tire->company_id)
                                          ->where('size_id', $tire->size_id)
                                          ->first();
            if($tireStock)
            {
                if($tireStock->quantity >= $tire->quantity)
                {
                    $tireStock->quantity -= $tire->quantity;

                    if($tireStock->save())
                    {
                        $tireStock = TireStock::where('company_id', $request->input('company_id'))
                                          ->where('size_id', $request->input('size_id'))
                                          ->first();

                        if(!$tireStock)
                        {
                            $tireStock = new TireStock();
                            $tireStock->company_id = $request->input('company_id');
                            $tireStock->size_id = $request->input('size_id');
                            $tireStock->quantity = $request->input('quantity');
                        }
                        else
                        {
                            $tireStock->quantity += $request->input('quantity');
                        }

                        $tireStock->price = $request->input('sale_price');

                        if($tireStock->save())
                        {
                            $tire->update($request->all());
                            DB::commit();
                            return $this->index();
                        }
                    }
                }
            }
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tire  $tire
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tire $tire)
    {
        try{
            DB::beginTransaction();
            $tireStock = TireStock::where('company_id', $tire->company_id)
                                  ->where('size_id', $tire->size_id)
                                  ->first();
            if($tireStock)
            {
                if($tireStock->quantity >= $tire->quantity)
                {
                    $tireStock->quantity -= $tire->quantity;

                    if($tireStock->save())
                    {
                        if($tire->delete())
                        {
                            DB::commit();
                            return $this->index();
                        }
                        else
                        {
                            DB::rollBack();
                            return response()->json(425, ['delete'=>'error deleting record']);
                        }
                    }
                }
            }
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
