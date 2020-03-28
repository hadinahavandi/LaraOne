<?php
namespace App\models\carserviceorder;

use App\User;
use Illuminate\Database\Eloquent\Model;

class carserviceorder_car extends Model
{
    protected $table = "carserviceorder_car";
    protected $fillable = ['title','maxmodel_num','minmodel_num','photo_igu','carmaker_fid'];
	public function carmaker()
    {
        return $this->belongsTo(carserviceorder_carmaker::class,'carmaker_fid')->first();
    }
}