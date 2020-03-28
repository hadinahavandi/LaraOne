<?php
namespace App\models\carserviceorder;

use App\User;
use Illuminate\Database\Eloquent\Model;

class carserviceorder_carmaker extends Model
{
    protected $table = "carserviceorder_carmaker";
    protected $fillable = ['title','logo_igu'];
}