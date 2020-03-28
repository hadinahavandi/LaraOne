<?php
namespace App\models\research;

use App\User;
use Illuminate\Database\Eloquent\Model;

class research_workstatus extends Model
{
    protected $table = "research_workstatus";
    protected $fillable = ['name'];
}