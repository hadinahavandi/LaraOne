<?php
namespace App\models\ifi;

use Illuminate\Database\Eloquent\Model;

class ifi_nationality extends Model
{
    protected $table = "ifi_nationality";
    protected $fillable = ['title','flag_flu'];
}