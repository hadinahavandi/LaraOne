<?php
namespace App\models\ifi;

use Illuminate\Database\Eloquent\Model;

class ifi_taxtype extends Model
{
    protected $table = "ifi_taxtype";
    protected $fillable = ['title'];
}