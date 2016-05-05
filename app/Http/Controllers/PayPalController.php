<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;


use App\Http\Requests;

class PayPalController extends Controller
{

    public function postPayment(Request $request){
        $user_id = $request->get('user_id');
        $date = $request->get('create_time');
        $fixed_date = date('Y-m-d H:i:s', strtotime($date));
        $transaction_id = $request->get('transaction_id');
        $amount = $request->get('amount');
        $currency_code = $request->get('currency_code');

        $paypal_conf = \Config::get('paypal');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $paypal_conf['client_id'].":".$paypal_conf['secret']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        $result = curl_exec($ch);


        $json = "";

        if(empty($result)) die("Error: No response.");
        else
        {
            $json = json_decode($result);
        }

        curl_close($ch);


        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.sandbox.paypal.com/v1/payments/payment/'. $transaction_id .'/?client_id='.$paypal_conf['client_id'].'&secret='.$paypal_conf['secret'],
        ));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $json->access_token
        ));
        $result = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($result);

       if($json->state == "approved" && $json->transactions[0]->amount->total == $amount && $json->transactions[0]->amount->currency == $currency_code && $json->transactions[0]->related_resources[0]->sale->state == "completed")
           return "success";
        else return "fail";

    }

    public function getPremiumTypes(){
        return DB::table('premium_types')->get();
    }

}