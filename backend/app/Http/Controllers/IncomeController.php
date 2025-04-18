<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeRequest;
use App\Services\IncomeService;

class IncomeController extends Controller
{

    protected $incomeService;
    public function __construct(IncomeService $incomeService){
        $this->incomeService = $incomeService;
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
        return response()->json([
            'message' => 'failed to fetch the data'
        ],400);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IncomeRequest $request)
    {
        $validateData = $request->validated();
        $income = $this->incomeService->create($validateData);
        if($income){
            return response()->json([
                'message' => 'Income created successfully',
                'income' => $income
            ], 201);
        }
        return response()->json([
            'message' => 'fialed to create income'
        ],422);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $incomeId)
    {
        $income = $this->incomeService->show($incomeId);
        if($income){
            return response()->json([
                'message' => 'income fetched seccussfully'
            ],200);
        }
        return response()->json([
            'message' => 'faild to fetch income'
        ],400);
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
                'message' => 'income Updated seccussfully'
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
