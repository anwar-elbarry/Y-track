<?php

namespace App\Services;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryService {
        public function getAll(){
               $categories = DB::table('categories')->where('user_id',Auth::id())->get();
            return $categories;
        }

        public  function create(array $categoryData){
            $category =  Category::create($categoryData);
            return $category;
        }

    
        public function remove(int $categoryId){
            $category = Category::findOrFail($categoryId);
            if($category->delete()){
                return true;
            }
            return false;
        }
}

