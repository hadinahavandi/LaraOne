<?php
namespace App\models\sas;

use App\User;
use Illuminate\Database\Eloquent\Model;

class sas_status extends Model
{
    protected $table = "sas_status";
    protected $fillable = ['name','priority','is_commited','is_successful'];
}