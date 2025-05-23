<?php

namespace App\Services;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
class ClientService {

   public function showAll(){
        $Clients = Client::with('incomes')->where('user_id',Auth::id())->get();
        return $Clients;
    }
   public function show(int $ClientId){
        $Client = Client::with('incomes')->findOrFail($ClientId);
        return $Client;
    }
   public  function create(array $ClientData){
        $Client =  Client::create($ClientData);
        return $Client;
    }

   public  function update(int $ClientId , array $ClientData){
        $Client = Client::findOrFail($ClientId);
        if($Client->update($ClientData)){
            return $Client;
        }
        return false;
    }
   public  function update_Linked_Incomes(int $ClientId ,float $income){
        $Client = Client::findOrFail($ClientId);
        if($Client['linked_incomes'] > 0){
                $income += $Client['linked_incomes'];
        }
        if($Client->update([
            'linked_incomes' => $income
        ])){
            return $income;
        }
        return false;
    }

    public function remove(int $ClientId){
        $Client = Client::findOrFail($ClientId);
        if($Client->delete()){
            return true;
        }
        return false;
    }

    public function removeMultiple(array $ClientsId){
        if(Client::destroy($ClientsId)){
            return true;
        }
        return false;
    }
}