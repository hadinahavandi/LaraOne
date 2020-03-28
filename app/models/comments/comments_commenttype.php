<?php
namespace App\models\comments;

use App\User;
use Illuminate\Database\Eloquent\Model;

class comments_commenttype extends Model
{
    protected $table = "comments_commenttype";
    protected $fillable = ['title','is_rated','is_uniquecomment'];
}