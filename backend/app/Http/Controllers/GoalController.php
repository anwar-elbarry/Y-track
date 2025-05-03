<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoalRequest;;
use App\Services\GoalService;
use App\Services\NotificationService;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;
use App\Services\TransactionService;

class GoalController extends Controller
{

    protected $goalService;
    protected $transactionService;
    protected $notificationService;

    public function __construct(GoalService $goalService,TransactionService $transactionService,NotificationService $notificationService){
        $this->goalService = $goalService;
        $this->transactionService = $transactionService;
        $this->notificationService = $notificationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goals = $this->goalService->showAll();
        if($goals){
            return response()->json([
                'message' => 'goals fetched successfully',
                'goals' => $goals
            ],200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GoalRequest $request)
    {
        $validateData = $request->validated();
        $validateData['user_id'] = Auth::id();
        $validateData['target_amount'] = (float)$validateData['target_amount'];
        $goal = $this->goalService->create($validateData);
        $danger = $this->notificationService->createDanger();

        if($goal){
            return response()->json([
                'message' => 'goal created successfully',
                'goal' => $goal,
                'danger' => $danger ?? NULL,
            ], 201);
        }

        return response()->json([
            'message' => 'Failed to create goal',
            'user_id' => Auth::id()
        ], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $goalId)
    {
        $goal = $this->goalService->show($goalId);
        if($goal){
            return response()->json([
                'message' => 'goal fetched seccussfully'
            ],200);
        }

        return response()->json([
            'message' => 'faild to fetch goal'
        ],400);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GoalRequest $request, string $goalId)
    {
        $validateData = $request->validated();
        
        $original_goal = Goal::findOrFail($goalId);
        
        $newSavedAmount = (float)$validateData['saved_amount'];
        $targetAmount = (float)$original_goal->target_amount;
        $currentSavedAmount = (float)$original_goal->saved_amount;
        
       
        $totalSavedAmount = $currentSavedAmount + $newSavedAmount;
        
       
        if ($totalSavedAmount > $targetAmount) {
            return response()->json([
                'message' => 'Total saved amount cannot exceed target amount'
            ], 400); 
        }
        
        
        $validateData['saved_amount'] = $totalSavedAmount;
        
     
        if ($totalSavedAmount >= $targetAmount) { 
            $validateData['status'] = 'completed';
        } else {
            $validateData['status'] = 'in_progress';
        }
        
        $goal = $this->goalService->update($goalId, $validateData);
        $this->transactionService->create([
            'amount' => $newSavedAmount,
            'goal_id' => $goal->id,
        ],'goal');
        
        if ($goal) {
            return response()->json([
                'message' => 'Goal updated successfully',
                'goal' => $goal
            ], 200);
        }
        
        return response()->json([
            'message' => 'Failed to update goal'
        ], 422);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $goalId)
    {
        $isDeleted = $this->goalService->remove($goalId);
        if($isDeleted){
            return response()->json([
                'message' => 'goal Deleted seccussfully'
            ],200);
        }


        return response()->json([
            'message' => 'faild to Delete goal'
        ],400);
    }
}
