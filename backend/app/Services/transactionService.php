<?php

namespace App\Services;
use App\Models\Transaction;
use Auth;
class TransactionService {

   public function showAll(){
        $Transactions = Transaction::with('user')->where('user_id',Auth::id())->get();
        return $Transactions;
    }
    public function create(array $transaction,string $type)
    {
        return Transaction::create([
            'user_id' => Auth::id(),
            'type' => $type,
            'amount' => $transaction['amount']
        ]);
    }


    public function remove(int $TransactionId){
        $Transaction = Transaction::findOrFail($TransactionId);
        if($Transaction->delete()){
            return true;
        }
        return false;
    }

    public function removeMultiple(array $TransactionsId){
        if(Transaction::destroy($TransactionsId)){
            return true;
        }
        return false;
    }
}