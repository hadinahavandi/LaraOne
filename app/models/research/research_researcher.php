<?php
namespace App\models\research;

use App\User;
use Illuminate\Database\Eloquent\Model;

class research_researcher extends Model
{
    protected $table = "research_researcher";
    protected $fillable = ['user_fid','name','family','university','studyfield','interestarea','tel_num','mob_num','email','workstatus_fid','universitygrade_fid','jobfield','role','bankcard_bnum','licence_igu','city','area','birthyear_num','ismale'];
	public function user()
    {
        return $this->belongsTo(User::class,'user_fid')->first();
    }
	public function workstatus()
    {
        return $this->belongsTo(research_workstatus::class,'workstatus_fid')->first();
    }
    public function universitygrade()
    {
        return $this->belongsTo(research_universitygrade::class,'universitygrade_fid')->first();
    }
}