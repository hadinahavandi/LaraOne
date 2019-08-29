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
    public static function newTransaction($api, $amount, $Description, $RedirectURL)
    {
        try {
            $UserID = Auth::user()->getAuthIdentifier();
//            $api = '598b9a1afff447b50fbdcfcec969d820';//trapp.sweetsoft.ir
//            $api = '9b92388e553ba7fd7e3a6d3f28facc45';//JspTutorial.sweetsoft.ir
            $factorNumber = 123;
            $result = PayDotIr::send($api, $amount, $RedirectURL, $factorNumber);
            $result = json_decode($result);
            if ($result == null || !property_exists($result, 'transId'))
                return ['transactionid' => '-2'];
            $TransactionID = $result->transId;
//            $TransactionID = "1147";
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
        $res = json_decode($res);
//        echo "STATUS:".$res->status;
//        echo "ERROR:".$res->errorCode;
//        echo "ERROR:".$res->errorMessage;
        if ($res->status != '1')
            throw new unsuccessfulPaymentException();
        return $res;
    }
}