<?php

namespace App\models\trapp;

use App\User;
use Illuminate\Database\Eloquent\Model;

class trapp_option extends Model
{
    protected $table = "trapp_option";
    protected $fillable = ['name', 'is_free', 'is_countable','is_managedbysystem'];
    public static function getNonFreeOptions()
    {
        return trapp_option::where('is_managedbysystem', '=', '0')->where('is_free', '=', "0")->get();
    }
    public static function getFreeOptions()
    {
        return trapp_option::where('is_managedbysystem', '=', '0')->where('is_free', '=', "1")->get();
    }
}