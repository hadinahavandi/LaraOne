<?php

namespace App\models\common;

use App\User;
use Illuminate\Database\Eloquent\Model;

class common_app extends Model
{
    protected $table = "common_app";
    protected $fillable = ['name'];
}