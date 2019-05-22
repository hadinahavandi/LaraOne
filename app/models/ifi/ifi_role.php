<?php
namespace App\models\ifi;

use Illuminate\Database\Eloquent\Model;

class ifi_role extends Model
{
    protected $table = "ifi_role";
    protected $fillable = ['title'];
}