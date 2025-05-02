<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use App\Http\Requests\NotificationRequest;
class NotificationController extends Controller
{

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $notifications = $this->notificationService->showAll();
            if($notifications){
                return response()->json([
                    'notifications' => $notifications,
                    'message' => 'Notifications fetched successfully'
                ], 200);
            }
            return response()->json(['message' => 'No notifications found'], 404);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $notification = $this->notificationService->remove($id);
        if($notification){
            return response()->json([
                'notification' => $notification,
                'message' => 'Notification deleted successfully'
            ], 200);
        }
        return response()->json(['message' => 'Failed to delete notification'], 400);
    }

    public function markAsRead($id)
    {
        $notification = $this->notificationService->markAsRead($id);
        if($notification){
            return response()->json([
                'notification' => $notification,
                'message' => 'Notification marked as read successfully'
            ], 200);
        }
        return response()->json(['message' => 'Failed to mark notification as read'], 400);
    }

   
}
