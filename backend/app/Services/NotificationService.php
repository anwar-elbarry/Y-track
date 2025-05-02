<?php

namespace App\Services;
use App\Models\Notification;
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

    public function markAsRead(int $notificationId){
        $notification = Notification::findOrFail($notificationId);
        $notification->is_read = true;
        $notification->save();
        return $notification;
    }

}