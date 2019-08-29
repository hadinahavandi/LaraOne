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
        $FoundDate = common_date::where('day_date', '=', $NormalTimeStamp)->get();
        if ($FoundDate->isEmpty())
            return false;
        return true;
    }

    public static function stringIsHoliday($Date)
    {
        $NormalTimeStamp = SweetDateManager::getTimeStampFromString($Date);
        $FoundDate = common_date::where('day_date', '=', $NormalTimeStamp)->get();
        if ($FoundDate->isEmpty())
            return false;
        return true;
    }

    public static function getTimeStampFromString($String, $format = 'Y/m/d')
    {
        if (strlen($String) == 10)//1370/08/15
            return Jalalian::fromFormat($format, $String)->getTimestamp();
        return 0;
    }

    public static function getStringFromTimeStamp($TimeStamp, $format = 'Y/m/d')
    {
        $DateInMorilogJalalian = jdate($TimeStamp);
        if (strlen($TimeStamp) > 1)
            return $DateInMorilogJalalian->format($format);
        return '';
    }

}