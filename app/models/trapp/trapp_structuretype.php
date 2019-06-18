<?php

namespace App\models\trapp;

use App\User;
use Illuminate\Database\Eloquent\Model;

class trapp_structuretype extends Model
{
    protected $table = "trapp_structuretype";
    protected $fillable = ['name'];
}