<?php
namespace App\models\mail;

use App\User;
use Illuminate\Database\Eloquent\Model;

class mail_mail extends Model
{
    protected $table = "mail_mail";
    protected $fillable = ['mailpost_fid','email','mailstatus_fid'];
	public function mailpost()
    {
        return $this->belongsTo(mail_mailpost::class,'mailpost_fid')->first();
    }
	public function mailstatus()
    {
        return $this->belongsTo(mail_mailstatus::class,'mailstatus_fid')->first();
    }
}