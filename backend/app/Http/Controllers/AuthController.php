<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Spatie\FlareClient\Api;
class AuthController extends Controller
{
    public function index(){
        $currencies = $this->CurrenciesApi();
        return response()->json([
          'currencies' => $currencies
        ],200);
    }
    // currency api function
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
             'name' => ['required','string'],
             'email' => ['required','string','unique:users,email'],
             'password' => ['required','string','min:8'],
             'currency' => ['string']
          ]);
          $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'currency' => $validated['currency'],
            'email_verified_at' => now()
          ]);

        return response()->json([
          'message' => 'User registered successfully',
          'user' => $user
      ], 201);
    }

    public function signIn(Request $request){
      $validate = $request->validate([
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string']
    ]);

    $user = User::where('email', $validate['email'])->first();

    if (!$user || !Hash::check($validate['password'], $user->password)) {
        return response()->json([
            'message' => 'Email ou mot de passe incorrect.'
        ], 401);
    }

    Auth::login($user);

    $token = $user->createToken('API Token')->plainTextToken;

    return response()->json([
        'message' => 'Utilisateur connecté avec succès.',
        'user' => $user,
        'token' => $token
    ], 200);
         
    }

    public function logOut(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
          'message' => 'user logged out seccussfully'
        ],200);
    }
}
