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
    public function isActive()
    {
        $lastRequest=$this->lastRequest();
        if($lastRequest==null)
            return true;
        return $lastRequest->status()->is_commited;
    }
    public function lastRequest()
    {
        $lastRequest=sas_request::where('device_fid','=',$this->id)->where('fullsend_time','>','0')->orderBy('id','desc')->first();
        return $lastRequest;
    }
    public function requests()
    {
        $Requests=sas_request::where('device_fid','=',$this->id)->where('fullsend_time','>','0')->orderBy('id','desc')->get();
        return $Requests;
    }
}