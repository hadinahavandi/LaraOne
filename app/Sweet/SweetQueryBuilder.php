<?php
/**
 * Created by PhpStorm.
 * User: hduser
 * Date: 2/18/19
 * Time: 1:17 AM
 */

namespace App\Sweet;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SweetQueryBuilder
{

    public static function WhereIfNotNull(Builder $QueryBuilder,$FiledName,$FieldValue,$Operator='=')
    {
        if($FiledName!=null && $FieldValue!=null)
            return $QueryBuilder->where($FiledName,$Operator,$FieldValue);
        return $QueryBuilder;
    }
    public static function OrderIfNotNull(Builder $QueryBuilder,$TestingFieldName,$SortFiledName,$IsDesc)
    {
        if($TestingFieldName!=null && $IsDesc!=null)
            return $QueryBuilder->orderBy($SortFiledName,$IsDesc==0?'asc':'desc');
        return $QueryBuilder;
    }

    public static function orderByFields(Builder $QueryBuilder,$Fields)
    {
        if($Fields!=null){

            $keys=array_keys($Fields);
            for($i=0;$i<count($keys);$i++)
            {
                $key=$keys[$i];
                $QueryBuilder=$QueryBuilder->orderBy($key,$Fields[$key]==0?'asc':'desc');
            }
        }
        return $QueryBuilder;
    }

    public static function setPaginationFromRequest(Builder $QueryBuilder, Request $request)
    {
        $QueryBuilder = SweetQueryBuilder::setPaginationIfNotNull($QueryBuilder, $request->get('__startrow'), $request->get('__pagesize'));
        return $QueryBuilder;

    }

    public static function setPaginationIfNotNull(Builder $QueryBuilder, $Skip, $PageSize)
    {
        if($Skip!==null)
            $QueryBuilder= $QueryBuilder->skip($Skip);
        if($PageSize!==null)
            $QueryBuilder= $QueryBuilder->limit($PageSize);
        return $QueryBuilder;
    }

    public static function WhereLikeIfNotNull(Builder $QueryBuilder,$FiledName,$FieldValue)
    {
        if($FieldValue==null)
            return $QueryBuilder;
        return SweetQueryBuilder::WhereIfNotNull($QueryBuilder,$FiledName,'%'.$FieldValue.'%','like');
    }
    public static function WhereIfNotNullFromArray(Builder $QueryBuilder,array $FiledNames,array $FieldValues,array $Operators=[])
    {
        if($FiledNames==null)
            return $QueryBuilder;
        $FiledCount=count($FiledNames);
        if(count($Operators)==0)
        {
            for($j=0;$j<$FiledCount;$j++)
                $Operators[$j]='=';
        }
        for($i=0;$i<$FiledCount;$i++)
        {
            $QueryBuilder=SweetQueryBuilder::WhereIfNotNull($QueryBuilder,$FiledNames[$i],$FieldValues[$i],$Operators[$i]);
        }
        return $QueryBuilder;
    }
}