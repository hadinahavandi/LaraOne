<?php
namespace App\models\posts;

use App\User;
use Illuminate\Database\Eloquent\Model;

class posts_category extends Model
{
    protected $table = "posts_category";
    protected $fillable = ['name','latinname','mother__category_fid'];
	public function mothercategory()
    {
        return $this->belongsTo(posts_category::class,'mother__category_fid')->first();
    }

    public static function getCatNameSubCats($CatLatinName){
	    $CatLatinName=trim(strtolower($CatLatinName));
        $theCat=posts_category::where('latinname','=',$CatLatinName)->get();
        if($theCat!=null && count($theCat)>0){
            $theCat=$theCat[0];
            return self::getSubCats($theCat->id);
        }
        return [];
    }
    public static function getSubCats($CatId){
        $result=[$CatId];
	    $subCats=posts_category::where('mother__category_fid','=',$CatId)->get();
        if($subCats!=null && count($subCats)>0){
            for($i=0;$i<count($subCats);$i++){
                $subCatSubs=posts_category::getSubCats($subCats[$i]->id);
                $result=array_merge($result,$subCatSubs);
            }
        }
        return $result;
    }
}