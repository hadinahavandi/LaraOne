<?php

namespace App\models\trapp;

use App\User;
use Illuminate\Database\Eloquent\Model;

class trapp_option extends Model
{
    protected $table = "trapp_option";
    protected $fillable = ['name', 'is_free', 'is_countable'];
}