<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class itsap_servicetype extends Model
{
    protected $table = "itsap_servicetype";
    protected $fillable = ['title','priority','servicetypegroup_fid','is_needdevice'];
}