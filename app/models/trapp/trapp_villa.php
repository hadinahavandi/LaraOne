<?php

namespace App\models\trapp;

use App\Http\Controllers\trapp\classes\villaOption;
use App\models\placeman\placeman_place;
use App\models\placeman\placeman_placephoto;
use App\User;
use Illuminate\Database\Eloquent\Model;

class trapp_villa extends Model
{
    protected $table = "trapp_villa";
    protected $fillable = ['roomcount_num', 'capacity_num', 'maxguests_num', 'structurearea_num', 'totalarea_num', 'placeman_place_fid', 'is_addedbyowner', 'viewtype_fid', 'structuretype_fid', 'is_fulltimeservice', 'timestart_clk', 'owningtype_fid', 'areatype_fid', 'description_te', 'documentphoto_igu', 'normalprice_prc', 'holidayprice_prc', 'weeklyoff_num', 'monthlyoff_num'];

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
        $Options = villaOption::getVillaOptions($this->id);
        return $Options;
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
        $orders = trapp_order::where('orderstatus_fid', '=', '2')->where('villa_fid', '=', $VillaID)->get();
        $days = [];
        $DayLength = 3600 * 24;
        for ($i = 0; $i < count($orders); $i++) {

            array_push($days, $orders[$i]->start_date);
            for ($d = 1; $d < $orders[$i]->duration_num; $d++)
                array_push($days, $orders[$i]->start_date + $d * $DayLength);

        }
        return $days;
    }

    public static function getIsVillaReservable($VillaID, $StartDate, $Duration)
    {
        $DayLength = 3600 * 24;
        $EndDate = (int)$StartDate + (int)$DayLength * ($Duration - 1);
        $NumOfOrdersInRange = trapp_order::where('orderstatus_fid', '=', '2')->where('villa_fid', '=', $VillaID)->where('start_date', '<=', $EndDate)->whereRaw("start_date+((duration_num-1)*$DayLength)>=$StartDate")->get()->count();
        return $NumOfOrdersInRange == 0;
    }


}