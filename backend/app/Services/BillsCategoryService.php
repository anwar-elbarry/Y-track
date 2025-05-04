<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\BillsCategory;
class BillsCategoryService {

   public function showAll(){
        $Categories = BillsCategory::where('user_id',Auth::id())->with('bills')->get();
        return $Categories;
    }
   public function show(int $CategoryId){
        $Category = BillsCategory::findOrFail($CategoryId);
        return $Category;
    }
   public  function create(array $CategoryData){
        $Category =  BillsCategory::create($CategoryData);
        return $Category;
    }

   public  function update(int $CategoryId , array $CategoryData){
        $Category = BillsCategory::findOrFail($CategoryId);
        if($Category->update($CategoryData)){
            return $Category;
        }
        return false;
    }

    public function remove(int $CategoryId){
        $Category = BillsCategory::findOrFail($CategoryId);
        if($Category->delete()){
            return true;
        }
        return false;
    }

        public function removeMultiple(array $CategoryIds){
            if(BillsCategory::destroy($CategoryIds)){
                return true;
            }
            return false;
        }
}