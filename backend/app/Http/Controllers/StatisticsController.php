<?php

namespace App\Http\Controllers;
use App\Services\StatisticsService;

use Illuminate\Http\Request;

class StatisticsController extends Controller
{

    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService){
            $this->statisticsService = $statisticsService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statistics = $this->statisticsService->getStatistics();
        if($statistics){
            return response()->json([
                'message' => 'statistics fetched successfully',
                'statistics' => $statistics
            ],200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
