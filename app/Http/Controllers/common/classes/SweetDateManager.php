<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 6/17/2019
 * Time: 1:15 PM
 */

namespace App\Http\Controllers\common\classes;


use App\models\common\common_date;
use Morilog\Jalali\Jalalian;

class SweetDateManager
{
    public static function isholiday($Date)
    {
        $DateInMorilogJalalian = jdate($Date);
        $NormalTimeStamp = $DateInMorilogJalalian->getTimestamp();
//        echo "\r\n".$Date . "= ".$NormalTimeStamp;
        $FoundDate = common_date::where('day_date', '=', $NormalTimeStamp)->get();
        if ($FoundDate->isEmpty())
            return false;
        return true;
    }
}