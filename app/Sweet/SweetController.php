<?php
namespace App\Sweet;
use App\models\contactus\contactus_message;
use App\Http\Controllers\Controller;
use App\Sweet\FieldType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SweetController extends Controller
{
protected function getNormalizedList(array $List)
{

    if($List==null || count($List)<=0)
        return $List;
    else {

        for($i=0;$i<count($List);$i++)
        {
            $List[$i]=$this->getNormalizedItem($List[$i]);
        }
        return $List;
    }
}
    protected function getNormalizedItem(array $Item)
    {
                $keys=array_keys($Item);
                for ($j = 0; $j < count($keys); $j++) {
                    $Key=$keys[$j];
                    $FieldName = FieldType::getPureFieldName($Key);
                    $tmp = $Item[$Key];
                    unset($Item[$Key]);
                    $Item[$FieldName] = $tmp;
                }
                return $Item;
    }
}