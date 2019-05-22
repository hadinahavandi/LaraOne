<?php
namespace App\models\ifi;

use Illuminate\Database\Eloquent\Model;

class ifi_programestimationemployee extends Model
{
    protected $table = "ifi_programestimationemployee";
    protected $fillable = ['employee_fid','activity_fid','programestimation_fid','employmenttype_fid','totalwork','workunit_fid'];
}