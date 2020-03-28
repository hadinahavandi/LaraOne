<?php
namespace App\models\comments;

use App\User;
use Illuminate\Database\Eloquent\Model;

class comments_tempuser extends Model
{
    protected $table = "comments_tempuser";
    protected $fillable = ['name','family','mobile_num','email','tel_num'];
}