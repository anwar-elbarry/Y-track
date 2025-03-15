<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
class AuthController extends Controller
{




    public function index(){
        $currencies = $this->CurrenciesApi();
        return view('auth.auth',compact("currencies"));
    }
    public function CurrenciesApi(){
        $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.apilayer.com/currency_data/list",
      CURLOPT_HTTPHEADER => array(
        "Content-Type: text/plain",
        "apikey: wivyuFtVgqbQgZi3j0jf6G49GNRU6FTX"
      ),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET"
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response,true);
    $currencies = $data['currencies'] ?? [];
    return $currencies;
    }

    public function signUp(Request $request){
          $validated = $request->validate([
             'name' => ['require','string'],
             'email' => ['require','string','unique:users,email'],
             'password' => ['require','string','min:8'],
             'currency' => ['string']
          ]);
          $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'currency' => $validated['currency']
          ]);
        Auth::login($user);
        return redirect()->route('auth');
    }

    public function signIn(Request $request){
         $validate = $request->validate([
             'email' => ['require','string'],
             'password' => ['require','string']
         ]);

         if(Auth::attempt($validate)){
            return redirect()->route('dashboard');
         }
         return redirect()->back()->with('error','The provided credentials do not match our records.');
    }
}
