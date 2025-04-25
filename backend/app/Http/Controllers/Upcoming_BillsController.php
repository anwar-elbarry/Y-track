<?php

namespace App\Http\Controllers;
use App\Services\Upcoming_BillsService;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class Upcoming_BillsController extends Controller
{

    protected $upcoming_billsService;
    protected $transactionService;

    public function __construct(Upcoming_BillsService $upcoming_billsService,TransactionService $transactionService)
    {
        $this->upcoming_billsService = $upcoming_billsService;
        $this->transactionService = $transactionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $upcoming_bills = $this->upcoming_billsService->showAll();
        if($upcoming_bills){
            return response()->json([
                'message' => 'Upcoming bills fetched successfully',
                'upcoming_bills' => $upcoming_bills
            ], 200);
        }
        return response()->json([
            'message' => 'No upcomming bills yet',
        ], 200);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $upcoming_bills = $this->upcoming_billsService->create($request->all());
        return response()->json([
            'message' => 'Upcoming bill created successfully',
            'upcoming_bill' => $upcoming_bills,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $upcoming_bill = $this->upcoming_billsService->show($id);
        return response()->json([
            'message' => 'Upcoming bill fetched successfully',
            'upcoming_bill' => $upcoming_bill
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function pay(string $id)
    {
        $upcoming_bill = $this->upcoming_billsService->pay($id);
        $upcoming_bill = $this->upcoming_billsService->show($id);
        $transaction = $this->transactionService->create([
            'amount' => $upcoming_bill->amount,
            'bill_id' => $upcoming_bill->bill_id,
            'user_id' => $upcoming_bill->user_id,
            'date' => now(),
            'type' => 'bill',
        ],'bill');
        return response()->json([
            'message' => 'Upcoming bill paid successfully',
            'upcoming_bill' => $upcoming_bill,
            'transaction' => $transaction
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $upcoming_bill = $this->upcoming_billsService->remove($id);
        return response()->json([
            'message' => 'Upcoming bill deleted successfully',
            'upcoming_bill' => $upcoming_bill
        ], 200);
    }
}
