<?php

namespace App\Http\Controllers;
use App\Http\Requests\BillRequest;
use App\Services\BillService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
                    'message' => 'bills fetched successfully',
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
        
        $bill = $this->billService->create($validateData);
        $transaction = $this->transactionService->create($validateData,'bill');
        
        if ($bill) {
            return response()->json([
                'message' => 'bill created successfully',
                'bill' => $bill,
                'transaction' => $transaction,
                'logo' => $validateData['logo'] ?? null
            ], 201);
        }
        
        return response()->json([
            'message' => 'Failed to create bill',
            'user_id' => Auth::id()
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
                    'message' => 'bill fetched seccussfully'
                ],200);
            }

            return response()->json([
                'message' => 'faild to fetch bill'
            ],400);
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
                    'message' => 'bill Updated seccussfully',
                    'Updated bill' => $bill
                ],200);
            }

            return response()->json([
                'message' => 'faild to Update bill'
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
                    'message' => 'bill Deleted seccussfully'
                ],200);
            }


            return response()->json([
                'message' => 'faild to Delete bill'
            ],400);

    }
    public function destroyMultiple(array $billsId)
    {

            $billsCount = count($billsId);
            $isDeleted = $this->billService->removeMultiple($billsId);
            if($isDeleted){
                return response()->json([
                    'message' => "{$billsCount} bill Deleted seccussfully"
                ],200);
            }

            return response()->json([
                'message' => 'faild to Delete bill'
            ],400);
    }
}
