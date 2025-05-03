<?php

namespace App\Services;
use App\Models\Bill;
use App\Models\Expense;
use App\Models\Goal;
use App\Models\Notification;
use App\Models\upcoming_bill;
use Auth;
USE Illuminate\Support\Facades\DB;
class NotificationService {

   public function showAll(){
        $notifications = Notification::where('user_id',Auth::id())->orderBy('created_at', 'desc')->get();
        return $notifications;
    }
   public  function create(array $notificationData){
        $notification =  Notification::create($notificationData);
        return $notification;
    }

    public function remove(int $notificationId){
        $notification = Notification::findOrFail($notificationId);
        if($notification->delete()){
            return true;
        }
        return false;
    }
    public function clearAll(){
      $deleted = Notification::where('user_id',Auth::id())->delete();
     if( $deleted ){
        return true ;
    }
    return false;
}

    public function markAsRead(int $notificationId){
        $notification = Notification::findOrFail($notificationId);
        $notification->is_read = true;
        $notification->save();
        return $notification;
    }

    public function createAlert(){
        $expenses = Expense::where('user_id',Auth::id())->get();
        $threshold_alert = Auth::user()->threshold_alert;
        $amount = $expenses->sum('amount');
        if($amount >= $threshold_alert){
           $notification = $this->create([
            'user_id' => Auth::id(),
            'type' => 'alert',
            'message' => "Your total expenses ($amount) have exceeded your threshold alert limit ($threshold_alert)"
            ]);
            return $notification;
        }
        return false;
    }
    public function createDanger(){
        $expenses = Expense::where('user_id', Auth::id())->get();
        $bills = upcoming_bill::where('user_id', Auth::id())
                                ->where('status','unpaid')
                                ->get();
        $goals = Goal::where('user_id', Auth::id())
                      ->where('status', 'in_progress')
                      ->get();
        $balance = Auth::user()->balance;
      
        $totalExpenses = $expenses->sum('amount');
        $upcomingBills = $bills->where('status', 'pending')->sum('amount');
        $totalGoals = $goals->sum('saved_amount');
        $totalCommitments = $totalExpenses + $upcomingBills + $totalGoals;
        
        if($totalCommitments > $balance){
            $notification = $this->create([
                'user_id' => Auth::id(),
                'type' => 'danger',
                'message' => "Warning: Your total commitments ($totalCommitments) including upcoming bills exceed your current balance ($balance)"
            ]);
            return $notification;
        }

        if($balance < ($totalCommitments * 0.1)){
            $notification = $this->create([
                'user_id' => Auth::id(),
                'type' => 'danger',
                'message' => "Critical: Your balance ($balance) is dangerously low compared to your commitments ($totalCommitments)"
            ]);
            return $notification;
        }

        return false;
    }
}