<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class FacebookAuthController extends Controller
{
    public function redirect(){
        return Socialite::driver('facebook')->redirect();
    }
    public function callback(){
        try{
           $facebookUser = Socialite::driver('facebook')->user();
           $user = User::where('facebook_id',$facebookUser->id)->first();
           
           if(!$user){
              
            $user = User::where('email',$facebookUser->getEmail())->first();
            if($user){
                $user->update(['facebook_id' => $facebookUser->getId()]);
            }else{
                $user = User::create([
                    'name' => $facebookUser->getName(),
                    'email' => $facebookUser->getEmail(),
                    'facebook_id' => $facebookUser->getId(),
                    'password' => Hash::make(uniqid()),
                    'email_verified_at' => now()
                ]);
            }
            
           }
           Auth::login($user);
           $token = $user->createToken('API token')->plainTextToken;
           return response()->json([
            'message' => 'You loged successfully',
            'user' => $user,
            'token' => $token
           ],200);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Failed to authenticate with Google'
            ],400);
        
        }
    }
}
