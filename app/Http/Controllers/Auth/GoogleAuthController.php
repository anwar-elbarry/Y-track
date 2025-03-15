<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        try{
           $googleUser = Socialite::driver('google')->user();
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
                    'email_verified_at' => now()
                ]);
            }
            
           }
           Auth::login($user);
           return to_route('dashboard');
        }catch(\Exception $e){
            return to_route('signin')->with('error','Failed to authenticate with Google:' . $e->getMessage());
        }
    }
}
