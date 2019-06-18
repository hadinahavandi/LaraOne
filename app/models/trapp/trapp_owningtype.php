<?php

namespace App\models\trapp;

use App\User;
use Illuminate\Database\Eloquent\Model;

class trapp_owningtype extends Model
{
    protected $table = "trapp_owningtype";
    protected $fillable = ['name'];
}