<?php
/**
 * Created by PhpStorm.
 * User: hduser
 * Date: 4/12/19
 * Time: 7:12 PM
 */

namespace App\Http\Controllers\sas\Classes;


use App\models\sas\sas_unit;
use App\models\sas\sas_unitsequence;
use Illuminate\Support\Facades\Auth;

class Unit
{
    public static $USERTYPE_USER=1;
    public static $USERTYPE_ADMIN=2;
    public static $USERTYPE_SECURITY=3;
    public static function getUserUnit()
    {
        $UserID=Auth::user()->getAuthIdentifier();
        $Unit = sas_unit::where(function($q) use ($UserID){
            $q->where('user__user_fid', $UserID)
                ->orWhere('admin__user_fid', $UserID)
                ->orWhere('security__user_fid', $UserID);
        })->first();
        return $Unit;
    }
    public static function getUserUnitAndType()
    {
        $UserID=Auth::user()->getAuthIdentifier();
        $UserType=Unit::$USERTYPE_USER;
        $Unit = sas_unit::where('user__user_fid', $UserID)->first();
        if($Unit==null){
            $UserType=Unit::$USERTYPE_ADMIN;
            $Unit = sas_unit::where('admin__user_fid', $UserID)->first();
        }

        if($Unit==null)
        {
            $UserType=Unit::$USERTYPE_SECURITY;
            $Unit = sas_unit::where('security__user_fid', $UserID)->first();
        }
        return ["unit"=>$Unit,'usertype'=>$UserType];
    }
    public static function getUserNextUnits()
    {
        $Unit=Unit::getUserUnit();
        $UnitsequenceQuery = sas_unitsequence::where('source__unit_fid',"=",$Unit->id);
        $Unitsequences=$UnitsequenceQuery->get();
        return $Unitsequences;
    }
    public static function isUnitInUserNextUnits($DestinationUnitID)
    {
        $Unit=Unit::getUserUnit();
        $UnitsequenceQuery = sas_unitsequence::where('source__unit_fid',"=",$Unit->id)->where('destination__unit_fid',"=",$DestinationUnitID);
        $Unitsequences=$UnitsequenceQuery->first();
        return $Unitsequences!=null;
    }
}
