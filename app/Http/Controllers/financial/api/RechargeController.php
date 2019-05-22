<?php

namespace App\Http\Controllers\financial\api;

use App\Http\Controllers\financial\classes\PayDotIr;
use App\models\Area;
use App\models\Branch;
use App\models\Branchadmin;
use App\models\City;
use App\models\Company;
use App\models\Place;
use App\models\Province;
use App\models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Exception;
use Validator;
use App\User;
use Illuminate\Support\Facades\Auth;

class RechargeController extends Controller
{
    public function newTransaction()
    {
        try
        {

            return response()->json(['transactionid'=>'-2'], 200);
            $ID=Auth::user()->getAuthIdentifier();
//            $ID=2;
            $api = '5a2f04bec7d74cd1292c20f04b10f97b';
            $amount = '1000';
            $redirect = "http://insurance-app.ir/financial/payment";
            $factorNumber = 123;
            $result=PayDotIr::send($api,$amount,$redirect,$factorNumber);
            $result = json_decode($result);
            Transaction::create(['amount'=>$amount,'transactionid'=>$result->transId,'status'=>1,'user_id'=>$ID]);
            return response()->json(['transactionid'=>$result->transId], 200);
        }
        catch (Exception $ex)
        {
//            echo $ex->getMessage();
            return response()->json(['transactionid'=>'-2'], 200);
        }

    }


}
