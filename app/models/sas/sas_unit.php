<?php
namespace App\models\sas;

use App\User;
use Illuminate\Database\Eloquent\Model;

class sas_unit extends Model
{
    protected $table = "sas_unit";
    protected $fillable = ['name','logo_igu','unittype_fid','is_needsadminapproval','user__user_fid','admin__user_fid','security__user_fid'];
	public function unittype()
    {
        return $this->belongsTo(sas_unittype::class,'unittype_fid')->first();
    }
	public function useruser()
    {
        return $this->belongsTo(User::class,'user__user_fid')->first();
    }
	public function adminuser()
    {
        return $this->belongsTo(User::class,'admin__user_fid')->first();
    }
	public function securityuser()
    {
        return $this->belongsTo(User::class,'security__user_fid')->first();
    }
}