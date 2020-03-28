<?php
namespace App\models\pages;

use App\User;
use Illuminate\Database\Eloquent\Model;

class pages_page extends Model
{
    protected $table = "pages_page";
    protected $fillable = ['name','title','content_te','is_published','keywords'];
}