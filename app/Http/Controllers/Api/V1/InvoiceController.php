<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\V1\StoreInvoiceRequest;
use App\Http\Requests\V1\BulkStoreInvoiceRequest;
use App\Http\Requests\V1\UpdateInvoiceRequest;
use App\Http\Resources\V1\InvoiceResource;
use App\Http\Resources\V1\InvoiceCollection;
use App\Filters\V1\InvoiceFilter;
use Illuminate\Support\Arr;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $filter = new InvoiceFilter();
        $queryItems = $filter->transform($request);

        if (count($queryItems) == 0) {
            return new InvoiceCollection(Invoice::paginate());
        } else {
            $invoices = Invoice::where($queryItems)->paginate();
            return new InvoiceCollection($invoices->appends($request->query()));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        //
    }

    public function bulkStore(BulkStoreInvoiceRequest $request)
    {
        $bulk = collect($request->validated())->map(function ($arr) {
            return [
                'customer_id' => $arr['customerId'],
                'amount' => $arr['amount'],
                'status' => $arr['status'],
                'billed_date' => $arr['billedDate'],
                'paid_date' => $arr['paidDate'],
            ];
        });
    
        // \Log::info('Final bulk data:', $bulk->toArray());
    
        Invoice::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
