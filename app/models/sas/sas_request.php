<?php
namespace App\models\sas;

use App\User;
use Illuminate\Database\Eloquent\Model;

class sas_request extends Model
{
    protected $table = "sas_request";
    protected $fillable = ['requesttype_fid','device_fid','description_te','priority','attachment_flu','status_fid','sender__unit_fid','receiver__unit_fid','current__unit_fid','adminacceptance_time','securityacceptance_time','fullsend_time','finalcommit_time','letternumber','letter_date','sender__user_fid'];
	public function requesttype()
    {
        return $this->belongsTo(sas_requesttype::class,'requesttype_fid')->first();
    }
	public function device()
    {
        return $this->belongsTo(sas_device::class,'device_fid')->first();
    }
	public function status()
    {
        return $this->belongsTo(sas_status::class,'status_fid')->first();
    }
	public function senderunit()
    {
        return $this->belongsTo(sas_unit::class,'sender__unit_fid')->first();
    }
	public function receiverunit()
    {
        return $this->belongsTo(sas_unit::class,'receiver__unit_fid')->first();
    }
	public function currentunit()
    {
        return $this->belongsTo(sas_unit::class,'current__unit_fid')->first();
    }
	public function senderuser()
    {
        return $this->belongsTo(User::class,'sender__user_fid')->first();
    }
}