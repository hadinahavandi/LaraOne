<?php

namespace App\models\placeman;

use App\User;
use Illuminate\Database\Eloquent\Model;

class placeman_phototype extends Model
{
    protected $table = "placeman_phototype";
    protected $fillable = ['name'];
}