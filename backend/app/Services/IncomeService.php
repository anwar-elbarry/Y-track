<?php

namespace App\Services;
use App\Models\Income;
USE Illuminate\Support\Facades\DB;
class IncomeService {

    function showAll(){
        $incomes = Income::all();
        return $incomes;
    }
    function create(array $incomeData){
        $income =  Income::create($incomeData);
        return $income;
    }

    function update(int $incomeId , array $incomeData){
        $income = Income::findOrFail($incomeId);
        if($income->update($incomeData)){
            return true;
        }
        return false;
    }

    function remove(int $incomeId){
        $income = Income::findOrFail($incomeId);
        if($income->delete()){
            return true;
        }
        return false;
    }

    function removeMultiple(array $incomesId){
        if(Income::destroy($incomesId)){
            return true;
        }
        return false;
    }
}