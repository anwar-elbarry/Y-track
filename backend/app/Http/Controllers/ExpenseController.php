<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Services\ExpenseService;
use App\Services\NotificationService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{

    protected $expenseService;
    protected $transactionService;
    protected $notificationService;
    public function __construct(ExpenseService $expenseService,TransactionService $transactionService, NotificationService $notificationService){
        $this->expenseService = $expenseService;
        $this->transactionService = $transactionService;
        $this->notificationService = $notificationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $expenses = $this->expenseService->showAll();
            if($expenses){
                return response()->json([
                    'message' => 'expenses fetched successfully',
                    'expenses' => $expenses
                ],200);
            }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request)
    {
            $validateData = $request->validated();
            $validateData['user_id'] = Auth::id();

            $expense = $this->expenseService->create($validateData);
            
            // Create transaction with expense_id
            $transactionData = array_merge($validateData, ['expense_id' => $expense->id]);
            $transaction = $this->transactionService->create($transactionData, 'expense');
            $alert = $this->notificationService->createAlert();
            $danger = $this->notificationService->createDanger();
            if($expense){
                return response()->json([
                    'message' => 'expense created successfully',
                    'expense' => $expense,
                    'transaction' => $transaction,
                    'alert' => $alert ?? NULL,
                    'danger' => $danger ?? NULL,
                ], 201);
            }

            return response()->json([
                'message' => 'Failed to create expense',
                'user_id' => Auth::id()
            ], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $expenseId)
    {
            $expense = $this->expenseService->show($expenseId);
            if($expense){
                return response()->json([
                    'message' => 'expense fetched successfully',
                    'expense' => $expense
                ],200);
            }

            return response()->json([
                'message' => 'failed to fetch expense'
            ],400);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseRequest $request,int $expenseId)
    {
            $validateData = $request->validated();
            $expense = $this->expenseService->update($expenseId,$validateData);

            if($expense){
                return response()->json([
                    'message' => 'expense Updated successfully',
                    'Updated expense' => $expense
                ],200);
            }

            return response()->json([
                'message' => 'failed to Update expense'
            ],422);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $expenseId)
    {
            $isDeleted = $this->expenseService->remove($expenseId);
            if($isDeleted){
                return response()->json([
                    'message' => 'expense Deleted successfully'
                ],200);
            }

            return response()->json([
                'message' => 'failed to Delete expense'
            ],400);
    }

    public function destroyMultiple(array $expensesId)
    {
            $expensesCount = count($expensesId);
            $isDeleted = $this->expenseService->removeMultiple($expensesId);
            if($isDeleted){
                return response()->json([
                    'message' => "{$expensesCount} expense Deleted successfully"
                ],200);
            }

            return response()->json([
                'message' => 'failed to Delete expense'
            ],400);
    }
}