<?php
namespace App\models\sas;

use App\User;
use Illuminate\Database\Eloquent\Model;

class sas_requesttype extends Model
{
    protected $table = "sas_requesttype";
    protected $fillable = ['name','priority','is_needssecurityacceptance','mother__requesttype_fid','is_hardwareneeded'];
	public function motherrequesttype()
    {
        return $this->belongsTo(sas_requesttype::class,'mother__requesttype_fid')->first();
    }
}