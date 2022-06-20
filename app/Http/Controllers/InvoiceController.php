<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

use Log;
use DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = Invoice::orderBy('id', 'desc');

        if($request->has('invoice_number') && $request->get('invoice_number') > 0)
        {
            $q->where('invoices.id', $request->get('invoice_number'));
        }
        
        if($request->has('date_from') && $request->get('date_from') > 0)
        {
            $q->whereDate('invoices.created_at', '>=', $request->get('date_from'));
        }
        
        if($request->has('date_to') && $request->get('date_to') > 0)
        {
            $q->whereDate('invoices.created_at', '<=', $request->get('date_to'));
        }
        
        /*if($request->has('product_id') && $request->get('product_id') > 0)
        {
            $invoices = $q->select('oil_invoices.*')->paginate(10);
            foreach($invoices as $invoice)
            {
                $invoice->items = $invoice->items()->where('product_id', $request->input('product_id'))->get();
            }
        }
        else
        {*/
            $invoices = $q->select('invoices.*')->with('items')->paginate(10);
        //}

        return request()->json(200, $invoices);
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
        Log::info(print_r($request->all(), true));

        try
        {
            DB::beginTransaction();

            $invoice = new Invoice();
            $invoice->total_bill = $request->input('total_bill');
            $invoice->discount = $request->input('discount');
            $invoice->amount_received = $request->input('amount_received');

            if($invoice->save())
            {
                foreach($request->input('invoices') as $obj)
                {
                    $invoiceItem = new InvoiceItem();
                    $obj = (object) $obj;

                    Log::info(print_r($obj, true));

                    $invoiceItem->invoice_id = $invoice->id;
                    $invoiceItem->item_id = $obj->id;

                    if($obj->type=='service')
                    {
                        $invoiceItem->item_name = $obj->item['name'];
                    }
                    elseif($obj->type=='tire')
                    {
                        $tire = \App\Models\TireStock::find($obj->id);
                        if($tire)
                        {
                            $invoiceItem->item_name = $tire->company->name . "<br />" . $tire->size->name;

                            $tire->quantity -= $obj->quantity;
                            $tire->save();
                        }
                    }

                    $invoiceItem->item_type = $obj->type;
                    $invoiceItem->quantity = $obj->quantity;
                    $invoiceItem->price = $obj->item['price'];
                    $invoiceItem->save();
                }
            }

            DB::commit();

            return request()->json(200, $invoice);
        }
        catch(\Exception $e)
        {
            DB::rollback();

            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $invoice->items;
        return $invoice;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
