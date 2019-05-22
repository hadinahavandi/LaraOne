<?php
namespace App\models\sas;

use App\User;
use Illuminate\Database\Eloquent\Model;

class sas_unittype extends Model
{
    protected $table = "sas_unittype";
    protected $fillable = ['name'];
}