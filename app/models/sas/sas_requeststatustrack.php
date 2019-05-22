<?php
namespace App\models\sas;

use App\User;
use Illuminate\Database\Eloquent\Model;

class sas_requeststatustrack extends Model
{
    protected $table = "sas_requeststatustrack";
    protected $fillable = ['status_fid','request_fid','user_fid'];
	public function status()
    {
        return $this->belongsTo(sas_status::class,'status_fid')->first();
    }
	public function request()
    {
        return $this->belongsTo(sas_request::class,'request_fid')->first();
    }
	public function user()
    {
        return $this->belongsTo(User::class,'user_fid')->first();
    }
}