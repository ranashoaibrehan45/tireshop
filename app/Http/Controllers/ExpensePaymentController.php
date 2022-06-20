<?php

namespace App\Http\Controllers;

use App\Models\ExpensePayment;
use App\Http\Requests\ExpensePaymentRequest;
use Illuminate\Http\Request;

class ExpensePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = ExpensePayment::orderBy('id', 'desc')->with('expense')->paginate(10);
        return request()->json(200, $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpensePaymentRequest $request)
    {
        ExpensePayment::create($request->all());
        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpensePayment  $expensePayment
     * @return \Illuminate\Http\Response
     */
    public function show(ExpensePayment $expensePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpensePayment  $expensePayment
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpensePayment $expensePayment)
    {
        return $expensePayment;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpensePayment  $expensePayment
     * @return \Illuminate\Http\Response
     */
    public function update(ExpensePaymentRequest $request, ExpensePayment $expensePayment)
    {
        $expensePayment->update($request->all());
        
        if($expensePayment)
        {
            return $this->index();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpensePayment  $expensePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpensePayment $expensePayment)
    {
        if($expensePayment->delete())
            return $this->index();
        else
            return response()->json(425, ['delete'=>'error deleting record']);
    }
}
