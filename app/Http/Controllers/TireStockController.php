<?php

namespace App\Http\Controllers;

use App\Models\TireStock;
use Illuminate\Http\Request;

use DB;

class TireStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = TireStock::orderBy('id', 'desc')
                    ->with('company')
                    ->with('size')
                    ->paginate(10);
                    
        return request()->json(200, $rows);
    }

    public function getTiresByCompanyAndSize($company_id, $size_id)
    {
        $rows = TireStock::where('company_id', $company_id)
                    ->where('size_id', $size_id)
                    ->with('company')
                    ->with('size')
                    ->first();
                    
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TireStock  $tireStock
     * @return \Illuminate\Http\Response
     */
    public function show(TireStock $tireStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TireStock  $tireStock
     * @return \Illuminate\Http\Response
     */
    public function edit($tireStock)
    {
        return TireStock::where('id', $tireStock)
                    ->with('company')
                    ->with('size')
                    ->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TireStock  $tireStock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TireStock $tireStock)
    {
        try
        {
            DB::beginTransaction();
            
            $tireStock->price = $request->input('price');
            
            if($tireStock->save())
            {
                DB::commit();
                return $this->index();
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
     * @param  \App\Models\TireStock  $tireStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(TireStock $tireStock)
    {
        //
    }
}
