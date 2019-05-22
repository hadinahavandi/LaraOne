<?php
namespace App\models\ifi;

use Illuminate\Database\Eloquent\Model;

class ifi_programestimation extends Model
{
    protected $table = "ifi_programestimation";
    protected $fillable = ['title','department_fid','class_fid','programmaketype_fid','totalprogramcount','timeperprogram','is_haslegalproblem','approval_date','end_date','add_date','producer_employee_fid','executor_employee_fid','paycenter_fid','makergroup_paycenter_fid'];
}