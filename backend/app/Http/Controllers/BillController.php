<?php

namespace App\Http\Controllers;
use App\Http\Requests\BillRequest;
use App\Jobs\GenerateBillTransactionJob;
use App\Services\BillService;
use App\Services\TransactionService;
use Date;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BillController extends Controller
{
    protected $billService;
    protected $transactionService;

    public function __construct(BillService $billService,TransactionService $transactionService){
        $this->billService = $billService;
        $this->transactionService = $transactionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $bills = $this->billService->showAll();
            if($bills){
                return response()->json([
                    'message' => 'Bills fetched successfully',
                    'bills' => $bills
                ],200);
            }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BillRequest $request)
    {
        Log::info('Bill Creation Request Data:', [
            'all_data' => $request->all(),
            'validated_data' => $request->validated()
        ]);
        
        $validateData = $request->validated();
        
        if ($request->hasFile('logo')) {
            if (!file_exists(storage_path('app/public/bills_logo'))) {
                mkdir(storage_path('app/public/bills_logo'), 0755, true);
            }
            
            $path = $request->file('logo')->store('bills_logo', 'public');
            $validateData['logo'] = $path; 
            
            Log::info('Logo path saved:', ['path' => $path]);
        } else {
            
            $validateData['logo'] = null;
        }
        
        $validateData['user_id'] = Auth::id();
        $validateData['status'] = 'active'; 
        
        $bill = $this->billService->create($validateData);
        
        if ($bill) {
           
            GenerateBillTransactionJob::dispatch($bill->id)->onQueue('default');
            
            return response()->json([
                'message' => 'Bill created successfully',
                'bill' => $bill,
                'logo' => $validateData['logo'] ?? null
            ], 201);
        }
        
        return response()->json([
            'message' => 'Failed to create bill',
            'user_id' => Auth::id()
        ], 422);
    }

    public function pay(int $billId)
    {
        $bill = $this->billService->show($billId);
        
        if (!$bill) {
            return response()->json([
                'message' => 'Bill not found'
            ], 404);
        }

        if ($bill->status === 'paid') {
            return response()->json([
                'message' => 'Bill is already paid'
            ], 422);
        }

        $transaction = $this->transactionService->create([
            'user_id' => Auth::id(),
            'bill_id' => $bill->id,
            'amount' => $bill->amount,
            'type' => 'bill',
            'category' => $bill->category,
            'date' => now()
        ],'bill');

        if ($transaction) {
            $bill->status = 'paid';
            $bill->save();

            
            GenerateBillTransactionJob::dispatch($bill->id);

            return response()->json([
                'message' => 'Bill paid successfully',
                'transaction' => $transaction,
            ], 200);
        }

        return response()->json([
            'message' => 'Failed to process payment'
        ], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $billId)
    {
            $bill = $this->billService->show($billId);
            if($bill){
                return response()->json([
                    'message' => 'Bill fetched successfully',
                    'bill' => $bill
                ],200);
            }

            return response()->json([
                'message' => 'Bill not found'
            ],404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BillRequest $request,int $billId)
    {
            $validateData = $request->validated();
            $bill = $this->billService->update($billId,$validateData);
            if($bill){
                return response()->json([
                    'message' => 'Bill updated successfully',
                    'bill' => $bill
                ],200);
            }

            return response()->json([
                'message' => 'Failed to update bill'
            ],422);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $billId)
    {
            $isDeleted = $this->billService->remove($billId);
            if($isDeleted){
                return response()->json([
                    'message' => 'Bill deleted successfully'
                ],200);
            }


            return response()->json([
                'message' => 'Failed to delete bill'
            ],400);

    }
    public function destroyMultiple(array $billsId)
    {

            $billsCount = count($billsId);
            $isDeleted = $this->billService->removeMultiple($billsId);
            if($isDeleted){
                return response()->json([
                    'message' => "{$billsCount} bills deleted successfully"
                ],200);
            }

            return response()->json([
                'message' => 'Failed to delete bills'
            ],400);
    }
}
