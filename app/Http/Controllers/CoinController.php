<?php

namespace App\Http\Controllers;

use App\Coin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    public function showDetails(Request $request, Coin $coin)
    {
        $coinDetails = $this->coinPageHistory($coin->symbol);
//        dd($coinHistoryDetails == new \stdClass());

        $price_data = [];
        if ($coinDetails != new \stdClass() && !isset($coinDetails->error)) {
            $priceData = $coinDetails->price;

            foreach ($priceData as $price) {
                $temp['x'] = Carbon::createFromTimestamp(intval($price[0] / 1000))->format('Y-m-d H:i');
                $temp['y'] = $price[1];
                array_push($price_data, $temp);
            }
//            dd($coinDetails);
            return view('/coinDetails', compact('coin', 'coinDetails', 'price_data'));
        } //        dd($price_data);
        else {
            $coinDetails = $this->frontCoin($coin->symbol);
//            dd($coinDetails);
            $coinDetails->usdPrice = $coinDetails->price;
            $coinHistoryDetails = $this->coinHistory($coin->symbol);
//            dd($coinHistoryDetails);
//            coincap.io/history/symbol code
            if ($coinHistoryDetails != new \stdClass() && !isset($coinHistoryDetails->error)) {
                $price_data = [];
                $price_Data = $coinHistoryDetails->price;

                foreach ($price_Data as $priceHistory) {
                    $temp['x'] = Carbon::createFromTimestamp(intval($priceHistory[0] / 1000))->format('Y-m-d H:i');
                    $temp['y'] = $priceHistory[1];
                    array_push($price_data, $temp);
                }
//                dd($price_data);
                return view('/coinDetails', compact('coin', 'coinDetails', 'price_data'));
            }
            else {
                   return ('404');
                }
        }
    }
    public function coinPageHistory($symbol)
    {
        $url = "http://www.coincap.io/page/$symbol";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $response_set = json_decode(curl_exec($ch));
//        dd($response_set);
        curl_close($ch);
        return ($response_set);
    }

    public function coinHistory($symbol)
    {
        $url ="http://www.coincap.io/history/$symbol";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $response_set = json_decode(curl_exec($ch));
//        dd($response_set);
        curl_close($ch);
        return ($response_set);
    }

    public function frontCoin($symbol)
    {
        $url ="http://www.coincap.io/front";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $response_set = json_decode(curl_exec($ch));
//        dd($response_set);
        curl_close($ch);


        $frontArray = array_filter($response_set, function ($var) use ($symbol) {
//            dd($var);
            return ($var->short == $symbol);
        });
        return array_first($frontArray);
    }
}
