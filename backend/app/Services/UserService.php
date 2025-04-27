<?php
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserService {
      
    public function ChangePassword(String $old,String $new){
                   $user = Auth::user();
                   if(!Hash::check($old,$user->password)){
                        return false;
                   }

                   $user->password = Hash::make($new);
                   $user->save();
                   return $user->password;
    }
    public function updateUser(array $userData){
                    $user = Auth::user();
                   $user->update($userData);
                   $user = User::where('id',$user->id)->first();
                   if($user){
                    return $user;
                   }
                   return false;
    }

}