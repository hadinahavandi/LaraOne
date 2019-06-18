<?php

namespace App\models\trapp;

use App\User;
use Illuminate\Database\Eloquent\Model;

class trapp_areatype extends Model
{
    protected $table = "trapp_areatype";
    protected $fillable = ['name'];
}