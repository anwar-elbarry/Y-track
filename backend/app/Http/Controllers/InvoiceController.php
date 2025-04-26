<?php

namespace App\Http\Controllers;

use App\Services\InvoiceService;
use App\Http\Requests\InvoiceRequest;
use Illuminate\Support\Facades\Auth;
class InvoiceController extends Controller
{

    protected $invoiceService;

    public function  __construct(InvoiceService $invoiceService){
        $this->invoiceService = $invoiceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = $this->invoiceService->getAllInvoices();
            if($invoices){
                return response()->json([
                    'message' => 'invoices fetched successfully',
                    'invoices' => $invoices
                ],200);
            }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        $invoice = $this->invoiceService->createInvoice($validated);

        if($invoice){
           $invoicePath =  $this->invoiceService->SendInvoice($invoice);
            return response()->json([
                'message' => 'Invoice created successfully',
                'invoice' => $invoice,
                'invoicePath' => $invoicePath ?? null
            ], 201);
        }
        return response()->json([
            'message' => 'Invoice creation failed',
        ], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
