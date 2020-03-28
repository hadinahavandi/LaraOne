<?php
namespace App\models\carserviceorder;

use App\User;
use Illuminate\Database\Eloquent\Model;

class carserviceorder_request extends Model
{
    protected $table = "carserviceorder_request";
    protected $fillable = ['latitude_flt','longitude_flt','carmakeyear_num','user_fid','car_fid'];
	public function user()
    {
        return $this->belongsTo(User::class,'user_fid')->first();
    }
	public function car()
    {
        return $this->belongsTo(carserviceorder_car::class,'car_fid')->first();
    }
}