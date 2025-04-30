<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\TransactionService;

class TransactionController extends Controller
{

    protected $transactionService;

    public function __construct(TransactionService $transactionService) {
        $this->transactionService = $transactionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = $this->transactionService->showAll();
        if($transactions){
            return response()->json([
                'message' => 'transactions fetched successfully',
                'transactions' => $transactions
            ],200);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $transactionId)
    {
            $isDeleted = $this->transactionService->remove($transactionId);
            if($isDeleted){
                return response()->json([
                    'message' => 'transaction Deleted seccussfully'
                ],200);
            }


            return response()->json([
                'message' => 'faild to Delete transaction'
            ],400);

    }
    public function destroyMultiple(array $transactionsId)
    {

            $transactionsCount = count($transactionsId);
            $isDeleted = $this->transactionService->removeMultiple($transactionsId);
            if($isDeleted){
                return response()->json([
                    'message' => "{$transactionsCount} transaction Deleted seccussfully"
                ],200);
            }

            return response()->json([
                'message' => 'faild to Delete transaction'
            ],400);
    }
}
