<?php

namespace App\Services;
use App\Models\Income;
USE Illuminate\Support\Facades\DB;
class IncomeService {

   public function showAll(){
        $incomes = Income::all();
        return $incomes;
    }
   public function show(int $incomeId){
        $income = Income::findOrFail($incomeId);
        return $income;
    }
   public  function create(array $incomeData){
        $income =  Income::create($incomeData);
        return $income;
    }

   public  function update(int $incomeId , array $incomeData){
        $income = Income::findOrFail($incomeId);
        if($income->update($incomeData)){
            return $income;
        }
        return false;
    }

    public function remove(int $incomeId){
        $income = Income::findOrFail($incomeId);
        if($income->delete()){
            return true;
        }
        return false;
    }

    public function removeMultiple(array $incomesId){
        if(Income::destroy($incomesId)){
            return true;
        }
        return false;
    }
}