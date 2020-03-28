<?php
namespace App\models\trapp;

use App\User;
use Illuminate\Database\Eloquent\Model;

class trapp_villanonfreeoption extends Model
{
    protected $table = "trapp_villanonfreeoption";
    protected $fillable = ['villa_fid','option_fid','is_optional','price_num','maxcount_num'];
	public function villa()
    {
        return $this->belongsTo(trapp_villa::class,'villa_fid')->first();
    }
	public function option()
    {
        return $this->belongsTo(trapp_option::class,'option_fid')->first();
    }
}