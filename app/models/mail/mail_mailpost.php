<?php
namespace App\models\mail;

use App\User;
use Illuminate\Database\Eloquent\Model;

class mail_mailpost extends Model
{
    protected $table = "mail_mailpost";
    protected $fillable = ['subject','content_te','name'];
}