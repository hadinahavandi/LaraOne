<?php
namespace App\models\posts;

use App\User;
use Illuminate\Database\Eloquent\Model;

class posts_post extends Model
{
    protected $table = "posts_post";
    protected $fillable = ['title','summary_te','content_te','thumbnail_flu'];
}