<?php

namespace App\Services;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
class TransactionService {

   public function showAll(){
        $Transactions = Transaction::with('user')->where('user_id',Auth::id())->get();
        return $Transactions;
    }
    public function create(array $transaction, string $type)
    {
        $transactionData = [
            'user_id' => Auth::id(),
            'type' => $type,
            'amount' => $transaction['amount']
        ];

        // Add expense_id if it exists
        if (isset($transaction['expense_id'])) {
            $transactionData['expense_id'] = $transaction['expense_id'];
        }

        $transaction = Transaction::create($transactionData);
        
        $user = Auth::user();
        if($type == 'income'){
            $user->balance += $transaction['amount'];
            $user->save();
        }else{
            $user->balance -= $transaction['amount'];
            $user->save();
        }
        return $transaction;
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