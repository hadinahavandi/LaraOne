<?php
namespace App\models\sas;

use App\User;
use Illuminate\Database\Eloquent\Model;

class sas_requestmessage extends Model
{
    protected $table = "sas_requestmessage";
    protected $fillable = ['message_te','request_fid','unit_fid','user_fid'];
	public function request()
    {
        return $this->belongsTo(sas_request::class,'request_fid')->first();
    }
	public function unit()
    {
        return $this->belongsTo(sas_unit::class,'unit_fid')->first();
    }
	public function user()
    {
        return $this->belongsTo(User::class,'user_fid')->first();
    }
}