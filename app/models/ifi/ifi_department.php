<?php
namespace App\models\ifi;

use Illuminate\Database\Eloquent\Model;

class ifi_department extends Model
{
    protected $table = "ifi_department";
    protected $fillable = ['title','region_fid'];
}