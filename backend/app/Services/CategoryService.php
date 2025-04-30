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
        public function getCategoryWithAmount(){
            $categories = DB::table('categories')
                ->select('categories.id', 'categories.name', DB::raw('COALESCE(SUM(expenses.amount), 0) as total_amount'))
                ->leftJoin('expenses', 'categories.id', '=', 'expenses.category_id')
                ->where('categories.user_id', Auth::id())
                ->groupBy('categories.id', 'categories.name')
                ->orderBy('total_amount', 'desc')
                ->get();
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
