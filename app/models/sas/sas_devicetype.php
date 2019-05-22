<?php
namespace App\models\sas;

use App\User;
use Illuminate\Database\Eloquent\Model;

class sas_devicetype extends Model
{
    protected $table = "sas_devicetype";
    protected $fillable = ['name','devicetype_fid','is_needssecurityacceptance'];
	public function devicetype()
    {
        return $this->belongsTo(sas_devicetype::class,'devicetype_fid')->first();
    }
}