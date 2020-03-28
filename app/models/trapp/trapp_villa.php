<?php

namespace App\models\trapp;

use App\Http\Controllers\trapp\classes\villaOption;
use App\models\comments\comments_comment;
use App\models\placeman\placeman_place;
use App\models\placeman\placeman_placephoto;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class trapp_villa extends Model
{
    protected $table = "trapp_villa";
    protected $fillable = ['roomcount_num', 'capacity_num', 'maxguests_num', 'structurearea_num', 'totalarea_num', 'placeman_place_fid', 'is_addedbyowner', 'viewtype_fid', 'structuretype_fid', 'is_fulltimeservice', 'timestart_clk', 'owningtype_fid', 'areatype_fid', 'description_te', 'documentphoto_igu', 'normalprice_prc', 'holidayprice_prc','normalpureprice_prc','discount_num', 'weeklyoff_num', 'monthlyoff_num'];

    public function placemanplace()
    {
        return $this->belongsTo(placeman_place::class, 'placeman_place_fid')->first();
    }

    public function viewtype()
    {
        return $this->belongsTo(trapp_viewtype::class, 'viewtype_fid')->first();
    }

    public function structuretype()
    {
        return $this->belongsTo(trapp_structuretype::class, 'structuretype_fid')->first();
    }

    public function owningtype()
    {
        return $this->belongsTo(trapp_owningtype::class, 'owningtype_fid')->first();
    }

    public function areatype()
    {
        return $this->belongsTo(trapp_areatype::class, 'areatype_fid')->first();
    }

    public function villaOwners()
    {
        $place = $this->placemanplace();
        $user = $place->user_fid;
        return trapp_villaowner::where('user_fid', '=', $user)->get();
    }

    public function photos()
    {
        return placeman_placephoto::where('place_fid', '=', $this->placeman_place_fid)->get();
    }

    public function options()
    {
        $Options = villaOption::getVillaOptions($this->id,true);
        return $Options;
    }

    public function nonfreeoptions()
    {
        $Options = villaOption::getVillaOptions($this->id,false);
        return $Options;
    }

    public function publishedComments()
    {
        return $this->_getCommentsQuery()->where('comments_comment.publish_time', '!=', "-1")->get();
    }
    public function allComments()
    {
        return $this->_getCommentsQuery()->get();
    }
    public function _getCommentsQuery()
    {
        return comments_comment::where('commenttype_fid', '=', '1')->where('subjectentity_fid', '=', $this->id);
    }

    public function rate()
    {
        $Res= comments_comment::where('commenttype_fid', '=', '1')->where('subjectentity_fid', '=', $this->id)->where('publish_time', '!=', "-1")->groupBy('subjectentity_fid')->get([DB::raw('avg(comments_comment.rate_num) AS rate')]);
        if($Res!=null)
        {
            $rArr=$Res->toArray();
            if(count($rArr)>0)
                return $rArr[0]['rate'];
        }
        return -1;
    }
    public static function getUserVillas($UserID)
    {

        return trapp_villa::getUserVillaWithPlace()->where('user_fid', '=', $UserID)->get();
    }


    public static function getUserVillaWithPlace()
    {

        return placeman_place::join('trapp_villa', 'placeman_place.id', '=', 'trapp_villa.placeman_place_fid');
    }

    public static function getReservedDaysOfVilla($VillaID)
    {
        $where=function ($query) {
            $query->where('orderstatus_fid', '=','2')->orWhere('orderstatus_fid', '=', '3');
        };
        return trapp_villa::getReservedWithStatusDaysOfVilla($VillaID,$where);
    }

    public static function getReservedWithStatusDaysOfVilla($VillaID,$where)
    {
        $orders = trapp_order::where($where)
            ->where('villa_fid', '=', $VillaID)->get();
        $days = [];
        $DayLength = 3600 * 24;
        for ($i = 0; $i < count($orders); $i++) {

            array_push($days, $orders[$i]->start_date);
            for ($d = 1; $d < $orders[$i]->duration_num; $d++)
                array_push($days, $orders[$i]->start_date + $d * $DayLength);

        }
        return $days;
    }

    public static function getReservedByOwnerDaysOfVilla($VillaID)
    {
        $where=function ($query) {
            $query->where('orderstatus_fid', '=','3');
        };
        return trapp_villa::getReservedWithStatusDaysOfVilla($VillaID,$where);

    }
    public static function getReservedByUsersDaysOfVilla($VillaID)
    {
        $where=function ($query) {
            $query->where('orderstatus_fid', '=','2');
        };
        return trapp_villa::getReservedWithStatusDaysOfVilla($VillaID,$where);

    }
    public static function getIsVillaReservable($VillaID, $StartDate, $Duration)
    {
        $DayLength = 3600 * 24;
        $EndDate = (int)$StartDate + (int)$DayLength * ($Duration - 1);
        $NumOfOrdersInRange = trapp_order::where(function ($query) {
            $query->where('orderstatus_fid', '=', '2')
                ->orWhere('orderstatus_fid', '=', '3');})->where('villa_fid', '=', $VillaID)
            ->where('start_date', '<=', $EndDate)->whereRaw("start_date+((duration_num-1)*$DayLength)>=$StartDate")
            ->get()->count();
        return $NumOfOrdersInRange == 0;
    }


}