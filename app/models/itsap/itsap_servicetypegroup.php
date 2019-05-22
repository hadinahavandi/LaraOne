<?php
namespace App\models\itsap;

use Illuminate\Database\Eloquent\Model;

class itsap_servicetypegroup extends Model
{
    protected $table = "itsap_servicetypegroup";
    protected $fillable = ['title','servicetypegroup_fid'];
}