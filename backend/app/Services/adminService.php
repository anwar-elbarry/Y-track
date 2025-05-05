<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AdminService {

    public function getAllUsers() {
        return User::all();
    }
    
    /**
     * Delete a user by ID
     */
    public function deleteUser(int $userId) {
        $user = User::findOrFail($userId);
        
        if (Auth::id() === $userId) {
            return false;
        }
        
        return $user->delete();
    }

    public function toggleUserStatus(int $userId, string $status) {
        $user = User::findOrFail($userId);
 
        if (Auth::id() === $userId) {
            return false;
        }
        
        $user->status = $status;
        $user->save();
        
        return $user;
    }

    public function getDashboardStats() {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        
        $startOfMonth = Carbon::now()->startOfMonth();
        $newUsers = User::where('created_at', '>=', $startOfMonth)->count();
        
        return [
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'newUsers' => $newUsers
        ];
    }
}