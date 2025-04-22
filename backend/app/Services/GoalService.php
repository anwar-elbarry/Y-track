<?php

namespace App\Services;
use App\Models\Goal;
use Auth;
class GoalService {

   public function showAll(){
        $goals = Goal::with('user')->where('user_id',Auth::id())->get();
        return $goals;
    }
   public function show(int $GoalId){
        $Goal = Goal::findOrFail($GoalId);
        return $Goal;
    }
   public  function create(array $GoalData){
        $Goal =  Goal::create($GoalData);
        return $Goal;
    }

   public  function update(int $goalId , array $goalData){
        $goal = Goal::findOrFail($goalId);
        if($goal->update($goalData)){
            return $goal;
        }
        return false;
    }

    public function remove(int $GoalId){
        $Goal = Goal::findOrFail($GoalId);
        if($Goal->delete()){
            return true;
        }
        return false;
    }

    public function removeMultiple(array $GoalsId){
        if(Goal::destroy($GoalsId)){
            return true;
        }
        return false;
    }
}