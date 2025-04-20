<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    protected $categoryService;
    public function __construct(CategoryService $categoryService){
         $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $categories = $this->categoryService->getAll();
            if($categories){
                return response()->json([
                    'message' => 'categories fetched successfully',
                    'categories' => $categories
                ],200);
            }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {

            $validateData = $request->validated();
            $validateData['user_id'] = Auth::id();

            $category = $this->categoryService->create($validateData);

            if($category){
                return response()->json([
                    'message' => 'category created successfully',
                    'category' => $category
                ], 201);
            }

            return response()->json([
                'message' => 'Failed to create category',
                'user_id' => Auth::id()
            ], 422);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $categoryId)
    {
            $isDeleted = $this->categoryService->remove($categoryId);
            if($isDeleted){
                return response()->json([
                    'message' => 'category Deleted seccussfully'
                ],200);
            }


            return response()->json([
                'message' => 'faild to Delete category'
            ],400);

    }
}
