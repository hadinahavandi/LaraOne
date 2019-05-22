<?php
/**
 * Created by PhpStorm.
 * User: hduser
 * Date: 1/11/19
 * Time: 8:18 PM
 */

namespace App\Sweet;

class FieldType{
    public static $TEXT=0;
    public static $TEXTAREA=9;
    public static $FID=1;
    public static $BOOLEAN=2;
    public static $METAINF=3;
    public static $ID=4;
    public static $FILE=5;
    public static $DATE=6;
    public static $AUTOTIME=7;
    public static $LARAVELMETAINF=8;
    public static $IMAGE=9;


    public static function getPureFieldName($FieldName)
    {
        $PureField=$FieldName;
        if (FieldType::getFieldType($FieldName) == FieldType::$FID)
            $PureField = substr($FieldName, 0, strlen($FieldName) - 4);
        if (FieldType::getFieldType($FieldName) == FieldType::$BOOLEAN)
        {
            if(substr($FieldName,0,2)=="is")// "Is and Is_
                $PureField = substr($FieldName, 2);
            else
                $PureField = substr($FieldName, 4);//Can_
        }

        $PureField=str_replace("_","",$PureField);
        return $PureField;
    }
    public static function getFieldType($FieldName)
    {

        $FieldName=strtolower($FieldName);
        if($FieldName=="id")
            return FieldType::$ID;
        if($FieldName=="role_systemuser_fid" ||
            $FieldName=="deletetime")
            return FieldType::$METAINF;
        if($FieldName=="readonly" ||
            $FieldName=="gender")
            return FieldType::$BOOLEAN;
        if(substr($FieldName,strlen($FieldName)-4)=="_fid")
            return FieldType::$FID;
        if(substr($FieldName,strlen($FieldName)-4)=="_flu")
            return FieldType::$FILE;
        if(substr($FieldName,strlen($FieldName)-4)=="_igu")
            return FieldType::$IMAGE;
        if(substr($FieldName,strlen($FieldName)-5)=="_date")
            return FieldType::$DATE;
        if(substr($FieldName,strlen($FieldName)-5)=="_time")
            return FieldType::$AUTOTIME;
        if(substr($FieldName,strlen($FieldName)-3)=="_te")
            return FieldType::$TEXTAREA;
        if(substr($FieldName,0,2)=="is" || substr($FieldName,0,4)=="can_")
            return FieldType::$BOOLEAN;
        if($FieldName=="updated_at" || $FieldName=="created_at" )
            return FieldType::$LARAVELMETAINF;
        return FieldType::$TEXT;
    }
//    private static function fieldTypesIsOneOf($TypeOfInputField,$FieldType)
//    {
//        if($FieldType==FieldType::$TEXT)
//            return true;
//    }
    public static function fieldTypesIsText($FieldType)
    {
        if($FieldType==FieldType::$TEXT)
            return true;
        if(FieldType::fieldTypesIsTextArea($FieldType))
            return true;
        return false;
    }
    public static function fieldTypesIsTextArea($FieldType)
    {
        if($FieldType==FieldType::$TEXTAREA)
            return true;
        return false;
    }

    public static function fieldIsText($FieldName)
    {
        $FieldType=FieldType::getFieldType($FieldName);
        return FieldType::fieldTypesIsText($FieldType);
    }
    public static function fieldIsTextArea($FieldName)
    {
        $FieldType=FieldType::getFieldType($FieldName);
        return FieldType::fieldTypesIsTextArea($FieldType);
    }
    public static function fieldTypesIsFileUpload($FieldType)
    {
        if($FieldType==FieldType::$FILE)
            return true;
        if($FieldType==FieldType::$IMAGE)
            return true;
        return false;
    }

    public static function fieldIsFileUpload($FieldName)
    {
        $FieldType=FieldType::getFieldType($FieldName);
        return FieldType::fieldTypesIsFileUpload($FieldType);
    }

}
?>