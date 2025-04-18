<?php

namespace App\Services;
use App\Models\Expense;
USE Illuminate\Support\Facades\DB;
class ExpenseService {

   public function showAll(){
        $Expenses = Expense::all();
        return $Expenses;
    }
   public function show(int $ExpenseId){
        $Expense = Expense::findOrFail($ExpenseId);
        return $Expense;
    }
   public  function create(array $ExpenseData){
        $Expense =  Expense::create($ExpenseData);
        return $Expense;
    }

   public  function update(int $ExpenseId , array $ExpenseData){
        $Expense = Expense::findOrFail($ExpenseId);
        if($Expense->update($ExpenseData)){
            return $Expense;
        }
        return false;
    }

    public function remove(int $ExpenseId){
        $Expense = Expense::findOrFail($ExpenseId);
        if($Expense->delete()){
            return true;
        }
        return false;
    }

    public function removeMultiple(array $ExpensesId){
        if(Expense::destroy($ExpensesId)){
            return true;
        }
        return false;
    }
}