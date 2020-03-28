<?php
namespace App\models\trapp;

use App\User;
use Illuminate\Database\Eloquent\Model;

class trapp_ordervillanonfreeoption extends Model
{
    protected $table = "trapp_ordervillanonfreeoption";
    protected $fillable = ['order_fid','villanonfreeoption_fid','count_num','startday_num','days_num','price_num'];
	public function order()
    {
        return $this->belongsTo(trapp_order::class,'order_fid')->first();
    }
	public function villanonfreeoption()
    {
        return $this->belongsTo(trapp_villanonfreeoption::class,'villanonfreeoption_fid')->first();
    }
}