<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 8/25/2018
 * Time: 4:22 PM
 */

namespace App\Http\Controllers\finance\classes;


use App\models\finance\finance_transaction;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class PayDotIr
{
    public static function newTransaction($amount, $Description, $RedirectURL)
    {
        try {
            $UserID = Auth::user()->getAuthIdentifier();
            $api = '5a2f04bec7d74cd1292c20f04b10f97b';
            $factorNumber = 123;
            $result = PayDotIr::send($api, $amount, $RedirectURL, $factorNumber);
            $result = json_decode($result);
//            $TransactionID=$result->transId;
            $TransactionID = "1147";
            $Transaction = finance_transaction::create(['amount_prc' => $amount, 'transactionid' => $TransactionID, 'status' => 1, 'user_fid' => $UserID, 'description_te' => $Description]);
            return ['finance_transaction' => $Transaction, 'transactionid' => $TransactionID];
        } catch (Exception $ex) {
//            echo $ex->getMessage();
            return ['transactionid' => '-2'];
        }

    }

    public static function send($api, $amount, $redirect, $factorNumber=null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://pay.ir/payment/send');
        curl_setopt($ch, CURLOPT_POSTFIELDS,"api=$api&amount=$amount&redirect=$redirect&factorNumber=$factorNumber");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    public static function verify($api, $transId) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://pay.ir/payment/verify');
        curl_setopt($ch, CURLOPT_POSTFIELDS, "api=$api&transId=$transId");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}