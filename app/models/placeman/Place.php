<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['title','description', 'latitude' , 'longitude','logo'];

}
