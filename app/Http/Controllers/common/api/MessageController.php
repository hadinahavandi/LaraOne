<?php

namespace App\Http\Controllers\common\api;

use App\models\Area;
use App\models\Branch;
use App\models\Branchadmin;
use App\models\City;
use App\models\Company;
use App\models\Place;
use App\models\Province;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function getMessages($VersionNumber)
    {
        $ID=Auth::user()->getAuthIdentifier();
        $Branchadmin=Branchadmin::where('user_id', $ID)->first();
        $Branch=Branch::where('branchadmin_id', $Branchadmin->id)->first();
        $message="";
        $messageType=0;
        if(!$Branch->isactive)
        {
            $message="حساب شما منتظر فعال سازی توسط مدیر سیستم است.";
            $messageType=3;
        }
        if($Branch->expire_at->lt(Carbon::now()))
        {

            $message="اعتبار حساب شما به اتمام رسیده است. لطفا از آیکن سمت راست در بالای صفحه برای تمدید اعتبار حساب استفاده نمایید";
            $messageType=2;
        }
        return response()->json([0=>['message'=>$message,'messagetype'=>$messageType,'link'=>'','displaytype'=>1]], 200);
    }


}
