<?php

namespace App\models\common;

use App\User;
use Illuminate\Database\Eloquent\Model;

class common_date extends Model
{
    protected $table = "common_date";
    protected $fillable = ['day_date', 'factor_dbl'];
}