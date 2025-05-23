<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeRequest;
use App\Jobs\GenerateTransactionJob;
use App\Services\IncomeService;
use App\Services\TransactionService;
use App\Services\ClientService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IncomeController extends Controller
{

    protected $incomeService;
    protected $transactionService;
    protected $clientService;
    public function __construct(IncomeService $incomeService,TransactionService $transactionService,ClientService $clientService){
        $this->incomeService = $incomeService;
        $this->transactionService = $transactionService;
        $this->clientService = $clientService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $incomes = $this->incomeService->showAll();
            if($incomes){
                return response()->json([
                    'message' => 'incomes fetched successfully',
                    'incomes' => $incomes
                ],200);
            }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IncomeRequest $request)
    {

            // $firstRun = Carbon::parse($request->start_date);

            $validateData = $request->validated();
            $validateData['user_id'] = Auth::id();

            $validateData['next_run_at'] = $request->start_at;

            $income = $this->incomeService->create($validateData);
            // $transaction = $this->transactionService->create($validateData,'income');
            if($validateData['client_id'] !== NULL){
                $clinet_incomes = $this->clientService->update_Linked_Incomes($validateData['client_id'],$validateData['amount']);
            }

            $firstRun = Carbon::parse($income->start_at);
            GenerateTransactionJob::dispatch($income->id)
                                    ->delay($firstRun->startOfDay());

            if($income){
                return response()->json([
                    'message' => 'Income created successfully',
                    'income' => $income,
                    'clinet_incomes' => $clinet_incomes ?? 'no client linked',
                ], 201);
            }

            return response()->json([
                'message' => 'Failed to create income',
                'user_id' => Auth::id()
            ], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $incomeId)
    {
        try {
            $income = $this->incomeService->show($incomeId);
            if($income){
                return response()->json([
                    'message' => 'income fetched seccussfully'
                ],200);
            }
            Log::warning('Failed to fetch income', [
                'income_id' => $incomeId
            ]);
            return response()->json([
                'message' => 'faild to fetch income'
            ],400);
        } catch (\Exception $e) {
            Log::error('Income Show Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'income_id' => $incomeId
            ]);
            return response()->json([
                'message' => 'Unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IncomeRequest $request,int $incomeId)
    {
            $validateData = $request->validated();
            $income = $this->incomeService->update($incomeId,$validateData);
            if($income){
                return response()->json([
                    'message' => 'income Updated seccussfully',
                    'Updated income' => $income
                ],200);
            }

            return response()->json([
                'message' => 'faild to Update income'
            ],422);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $incomeId)
    {
            $isDeleted = $this->incomeService->remove($incomeId);
            if($isDeleted){
                return response()->json([
                    'message' => 'income Deleted seccussfully'
                ],200);
            }


            return response()->json([
                'message' => 'faild to Delete income'
            ],400);

    }
    public function destroyMultiple(array $incomesId)
    {

            $incomesCount = count($incomesId);
            $isDeleted = $this->incomeService->removeMultiple($incomesId);
            if($isDeleted){
                return response()->json([
                    'message' => "{$incomesCount} income Deleted seccussfully"
                ],200);
            }

            return response()->json([
                'message' => 'faild to Delete income'
            ],400);
    }
}
