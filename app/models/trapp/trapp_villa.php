<?php

namespace App\models\trapp;

use App\models\placeman\placeman_place;
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
}