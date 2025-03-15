<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(){
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
$i=0;
foreach($currencies as $currencyCode => $currencyName){
   echo $currencyCode;
   echo '<br>';
}
    }
}
