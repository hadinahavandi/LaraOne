<?php
namespace App\models\mail;

use App\User;
use Illuminate\Database\Eloquent\Model;

class mail_mailstatus extends Model
{
    protected $table = "mail_mailstatus";
    protected $fillable = ['name'];
}