<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\upcoming_bill;
class Upcoming_BillsService {

   public function showAll(){
        $upcoming_bills = upcoming_bill::where('user_id',Auth::id())->with('originalBill')->get();
        return $upcoming_bills;
    }
   public function show(int $upcoming_billId){
        $upcoming_bill = upcoming_bill::findOrFail($upcoming_billId);
        return $upcoming_bill;
    }
   public  function create(array $upcoming_billData){
        $upcoming_bill =  upcoming_bill::create($upcoming_billData);
        return $upcoming_bill;
    }

   public  function pay(int $upcoming_billId){
        $upcoming_bill = upcoming_bill::findOrFail($upcoming_billId);
        if($upcoming_bill->update(['status' => 'paid'])){
            return $upcoming_bill;
        }
        return false;
    }

    public function remove(int $upcoming_billId){
        $upcoming_bill = upcoming_bill::findOrFail($upcoming_billId);
        if($upcoming_bill->delete()){
            return true;
        }
        return false;
    }

    public function removeMultiple(array $upcoming_billIds){
        if(upcoming_bill::destroy($upcoming_billIds)){
            return true;
        }
        return false;
    }
}