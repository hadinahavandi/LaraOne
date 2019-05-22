<?php
namespace App\models\sas;

use App\User;
use Illuminate\Database\Eloquent\Model;

class sas_unitsequence extends Model
{
    protected $table = "sas_unitsequence";
    protected $fillable = ['source__unit_fid','destination__unit_fid'];
	public function sourceunit()
    {
        return $this->belongsTo(sas_unit::class,'source__unit_fid')->first();
    }
	public function destinationunit()
    {
        return $this->belongsTo(sas_unit::class,'destination__unit_fid')->first();
    }
}