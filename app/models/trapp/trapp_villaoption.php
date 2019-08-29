<?php

namespace App\models\trapp;

use App\User;
use Illuminate\Database\Eloquent\Model;

class trapp_villaoption extends Model
{
    protected $table = "trapp_villaoption";
    protected $fillable = ['villa_fid', 'option_fid', 'count_num'];

    public function villa()
    {
        return $this->belongsTo(trapp_villa::class, 'villa_fid')->first();
    }

    public function option()
    {
        return $this->belongsTo(trapp_option::class, 'option_fid')->first();
    }

    public static function getVillaOptionsByVilla($VillaID)
    {
//        $Res=trapp_option::leftJoin('trapp_villaoption','trapp_villaoption.option_fid','=','trapp_option.id')
//            ->where('villa_fid','=',$VillaID)->get(['trapp_option.*','trapp_villaoption.count_num']);
//        return $Res;
    }

}