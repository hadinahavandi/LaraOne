<?php
namespace App\models\research;

use App\User;
use Illuminate\Database\Eloquent\Model;

class research_universitygrade extends Model
{
    protected $table = "research_universitygrade";
    protected $fillable = ['name'];
}