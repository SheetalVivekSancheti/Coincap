<?php

namespace App\Http\Controllers;

use App\Coin;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function scrap_coin()
    {
        $url = 'http://www.coincap.io/map';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $response_set = json_decode(curl_exec($ch));
//        dd($response_set);
        curl_close($ch);
        try {
            foreach ($response_set as $key => $c) {
                if(!is_null($c)) {
                    $coinName = $c->name;
                    $coinSymbol = $c->symbol;
                    $coin = Coin::firstOrNew(['symbol' => $coinSymbol]);
                    $coin->name = $coinName;
                    $coin->save();
                }
            }
            echo "coin saved";
        }
        catch(\Exception $e){
            dd($e->getMessage());
        }
    }
}
