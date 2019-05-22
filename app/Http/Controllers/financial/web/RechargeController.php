<?php

namespace App\Http\Controllers\financial\web;

use App\Http\Controllers\financial\classes\PayDotIr;
use App\models\Branch;
use App\models\Branchadmin;
use App\models\Category;
use App\models\Context;
use App\models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RechargeController extends Controller
{
    public function startPayment($TransactionID)
    {

        $Transaction=Transaction::where('transactionid', $TransactionID)->first();
        $Transaction->status=2;
        $Transaction->save();
        $go = "https://pay.ir/payment/gateway/$TransactionID";
        header("Location: $go");
    }
    public function verifyPayment(Request $request)
    {
        $api = '5a2f04bec7d74cd1292c20f04b10f97b';
        $transId = $request->input('transId');
        $Transaction=Transaction::where('transactionid', $transId)->first();
        $Transaction->status=3;
        $Transaction->save();
        $user_id=$Transaction->user_id;
        $Branchadmin = Branchadmin::where('user_id', $user_id)->first();
        $Branch = Branch::where('branchadmin_id', $Branchadmin->id)->first();
        $expire_at=Carbon::createFromFormat('Y-m-d H:i:s', $Branch->expire_at->format("Y-m-d H:i:s"));
        $Branch->expire_at=$expire_at->addDays(31);
        $Branch->save();
        $result = PayDotIr::verify($api,$transId);
        return "پرداخت با موفقیت انجام شد.";
    }
}
