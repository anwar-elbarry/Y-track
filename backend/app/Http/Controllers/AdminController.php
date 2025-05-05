<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * Get all users
     */
    public function getAllUsers()
    {
        $users = $this->adminService->getAllUsers();
        if($users){
            return response()->json([
                'users' => $users
            ],200);
        }
        return response()->json([
            'message' => 'no failed to fetch users'
        ],401);
    }

    /**
     * Get dashboard statistics
     */
    public function getDashboardStats()
    {
        $stats = $this->adminService->getDashboardStats();
        
        return response()->json($stats);
    }

    /**
     * Update user status
     */
    public function updateStatus(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:active,suspended'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $this->adminService->toggleUserStatus($id, $request->status);

        if (!$user) {
            return response()->json([
                'message' => 'Failed to update user status'
            ], 500);
        }

        return response()->json([
            'message' => 'User status updated successfully',
            'user' => $user
        ]);
    }

    /**
     * Delete a user
     */
    public function destroy(string $id)
    {
        $result = $this->adminService->deleteUser($id);

        if (!$result) {
            return response()->json([
                'message' => 'Failed to delete user or attempted to delete your own account'
            ], 500);
        }

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
