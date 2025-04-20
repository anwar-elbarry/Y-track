<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Services\ExpenseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{

    protected $expenseService;
    public function __construct(ExpenseService $expenseService){
        $this->expenseService = $expenseService;
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

            if($expense){
                return response()->json([
                    'message' => 'expense created successfully',
                    'expense' => $expense
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
                    'message' => 'expense fetched seccussfully'
                ],200);
            }

            return response()->json([
                'message' => 'faild to fetch expense'
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
                    'message' => 'expense Updated seccussfully',
                    'Updated expense' => $expense
                ],200);
            }

            return response()->json([
                'message' => 'faild to Update expense'
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
                    'message' => 'expense Deleted seccussfully'
                ],200);
            }


            return response()->json([
                'message' => 'faild to Delete expense'
            ],400);

    }
    public function destroyMultiple(array $expensesId)
    {

            $expensesCount = count($expensesId);
            $isDeleted = $this->expenseService->removeMultiple($expensesId);
            if($isDeleted){
                return response()->json([
                    'message' => "{$expensesCount} expense Deleted seccussfully"
                ],200);
            }

            return response()->json([
                'message' => 'faild to Delete expense'
            ],400);
    }
}