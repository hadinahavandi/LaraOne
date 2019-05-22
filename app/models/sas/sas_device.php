<?php
namespace App\models\sas;

use App\User;
use Illuminate\Database\Eloquent\Model;

class sas_device extends Model
{
    protected $table = "sas_device";
    protected $fillable = ['name','devicetype_fid','code','note_te','owner__unit_fid'];
	public function devicetype()
    {
        return $this->belongsTo(sas_devicetype::class,'devicetype_fid')->first();
    }
	public function ownerunit()
    {
        return $this->belongsTo(sas_unit::class,'owner__unit_fid')->first();
    }
}