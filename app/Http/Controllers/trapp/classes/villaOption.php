<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 8/14/2019
 * Time: 6:21 PM
 */

namespace App\Http\Controllers\trapp\classes;


use App\models\trapp\trapp_option;
use App\models\trapp\trapp_villaoption;

class villaOption
{

    public static function getVillaOptions($VillaID)
    {
        $VillaoptionQuery = trapp_option::where('id', '>=', '0');
        $VillaoptionsCount = $VillaoptionQuery->get()->count();
        $Villaoptions = $VillaoptionQuery->get();
        $VillaoptionsArray = [];
        for ($i = 0; $i < count($Villaoptions); $i++) {
            $VillaoptionsArray[$i] = $Villaoptions[$i]->toArray();
            $villOptQ = trapp_villaoption::where('villa_fid', '=', $VillaID)->where('option_fid', '=', $Villaoptions[$i]->id)->first();
            $value = 0;
            if ($villOptQ != null)
                $value = $villOptQ->count_num;
            $VillaoptionsArray[$i]['countnum'] = $value;
        }
        return ['data' => $VillaoptionsArray, 'count' => $VillaoptionsCount];
    }
}