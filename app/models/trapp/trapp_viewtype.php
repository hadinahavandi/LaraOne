<?php

namespace App\models\trapp;

use App\User;
use Illuminate\Database\Eloquent\Model;

class trapp_viewtype extends Model
{
    protected $table = "trapp_viewtype";
    protected $fillable = ['name'];
}