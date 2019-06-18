<?php

namespace App\models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Branch extends Model
{
    public static $EXPIRED=1;
    public static $NOT_EXPIRED=2;
    public static $ALL=0;
    protected $fillable = ['title','tel','email','address','isactive','fundationyear','code','photourl','expire_at','company_id','area_id','place_id','branchadmin_id'];
    protected $dates = ['expire_at'];
    public static function getBranchPlaces($count,$ActivationStatus,$ExpireStatus)
    {
        $result=DB::table('branches')
            ->join('places', 'branches.place_id', '=', 'places.id')
            ->join('companies', 'branches.company_id', '=', 'companies.id');
        if($ActivationStatus>=0)
        {
            if($ActivationStatus==0)
                $isActive=false;
            elseif($ActivationStatus==1)
                $isActive=true;
            $result=$result->where('branches.isactive',$isActive);
        }
        if($ExpireStatus==Branch::$ALL)
        {
            //Don't Consider Expiration Date
        }
        if($ExpireStatus==Branch::$NOT_EXPIRED)//Only Not Expired Branches
            $result=$result->whereDate('expire_at', '>=', Carbon::now());
        if($ExpireStatus==Branch::$EXPIRED)//Only Expired Branches
            $result=$result->whereDate('expire_at', '<', Carbon::now());
        $result=$result->take($count)
            ->get(array(

                'branches.title',
                'branches.isactive',
                'branches.address as description',
                'companies.logo_url as logo',
                'places.latitude',
                'places.longitude',
                'branches.id as branch_id',


            ));
        return $result;
    }
}
