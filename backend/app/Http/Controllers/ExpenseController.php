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
            $expences = $this->expenseService->showAll();
            if($expences){
                return response()->json([
                    'message' => 'expences fetched successfully',
                    'expences' => $expences
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

            $expence = $this->expenseService->create($validateData);

            if($expence){
                return response()->json([
                    'message' => 'expence created successfully',
                    'expence' => $expence
                ], 201);
            }

            return response()->json([
                'message' => 'Failed to create expence',
                'user_id' => Auth::id()
            ], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $expenceId)
    {
            $expence = $this->expenseService->show($expenceId);
            if($expence){
                return response()->json([
                    'message' => 'expence fetched seccussfully'
                ],200);
            }

            return response()->json([
                'message' => 'faild to fetch expence'
            ],400);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseRequest $request,int $expenceId)
    {
            $validateData = $request->validated();
            $expence = $this->expenseService->update($expenceId,$validateData);
            if($expence){
                return response()->json([
                    'message' => 'expence Updated seccussfully',
                    'Updated expence' => $expence
                ],200);
            }

            return response()->json([
                'message' => 'faild to Update expence'
            ],422);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $expenceId)
    {
            $isDeleted = $this->expenseService->remove($expenceId);
            if($isDeleted){
                return response()->json([
                    'message' => 'expence Deleted seccussfully'
                ],200);
            }


            return response()->json([
                'message' => 'faild to Delete expence'
            ],400);

    }
    public function destroyMultiple(array $expencesId)
    {

            $expencesCount = count($expencesId);
            $isDeleted = $this->expenseService->removeMultiple($expencesId);
            if($isDeleted){
                return response()->json([
                    'message' => "{$expencesCount} expence Deleted seccussfully"
                ],200);
            }

            return response()->json([
                'message' => 'faild to Delete expence'
            ],400);
    }
}
