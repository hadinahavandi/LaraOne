<?php
namespace App\models\ifi;

use Illuminate\Database\Eloquent\Model;

class ifi_employmenttype extends Model
{
    protected $table = "ifi_employmenttype";
    protected $fillable = ['title','taxfactor'];
}