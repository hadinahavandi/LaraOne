<?php

namespace App\models\trapp;

use App\User;
use Illuminate\Database\Eloquent\Model;

class trapp_orderstatus extends Model
{
    protected $table = "trapp_orderstatus";
    protected $fillable = ['name'];
}