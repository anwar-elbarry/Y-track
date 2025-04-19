<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')
        ->stateless()
        ->redirect();
    }

    public function callback(){
        try{
           $googleUser = Socialite::driver('google')
           ->stateless()
           ->user();
           $user = User::where('google_id',$googleUser->id)->first();
           
           if(!$user){
              
            $user = User::where('email',$googleUser->getEmail())->first();
            if($user){
                $user->update(['google_id' => $googleUser->getId()]);
            }else{
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(uniqid()),
                    'email_verified_at' => now()
                ]);
            }
            
           }
           Auth::login($user);
           $token = $user->createToken('API token')->plainTextToken;
           return redirect('http://localhost:5173/auth?token=' . $token . '&user=' . urlencode(json_encode($user)));
        }catch(\Exception $e){

            \Log::error('Google Auth Error: ' . $e->getMessage());        
        
        return redirect('http://localhost:5173/auth?error=' . urlencode($e->getMessage()));
        
        }
    }
}
