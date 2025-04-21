<?php

namespace App\Services;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
class BillService {

   public function showAll(){
        $Bills = Bill::with('Category')->where('user_id',Auth::id())->get();
        return $Bills;
    }
   public function show(int $BillId){
        $Bill = Bill::findOrFail($BillId);
        return $Bill;
    }
   public  function create(array $BillData){
        $Bill =  Bill::create($BillData);
        return $Bill;
    }

   public  function update(int $BillId , array $BillData){
        $Bill = Bill::findOrFail($BillId);
        if($Bill->update($BillData)){
            return $Bill;
        }
        return false;
    }

    public function remove(int $BillId){
        $Bill = Bill::findOrFail($BillId);
        if($Bill->delete()){
            return true;
        }
        return false;
    }

    public function removeMultiple(array $BillsId){
        if(Bill::destroy($BillsId)){
            return true;
        }
        return false;
    }
}